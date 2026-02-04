<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderCreatedMail;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cartItems = ProductCart::with('product')
                ->where('user_id',Auth::id())->get();
        } else {
            $cartItems = collect(session('cart',[]))->map(
                fn($qty,$id)=>(object)[
                    'product'=>Product::findOrFail($id),
                    'quantity'=>$qty
                ]
            );
        }   

        $subtotal = $cartItems->sum(
            fn($i)=>$i->quantity*$i->product->final_price
        );

        return view('checkout.index',compact('cartItems','subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'          => ['required', 'email'],
            'first_name'     => ['required', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:50'],
            'document_type'  => ['required', 'in:rut,passport'],
            'rut'            => ['required_if:document_type,rut', 'nullable', 'string', 'max:50'],
            'passport'       => ['required_if:document_type,passport', 'nullable', 'string', 'max:50'],
            'delivery_type'  => ['required', 'in:shipping,pickup'],
            'commune'        => ['required_if:delivery_type,shipping', 'nullable', 'string', 'max:255'],
            'street'         => ['required_if:delivery_type,shipping', 'nullable', 'string', 'max:255'],
            'number'         => ['required_if:delivery_type,shipping', 'nullable', 'string', 'max:50'],
            'extra'          => ['nullable', 'string', 'max:255'],
            'postal_code'    => ['nullable', 'string', 'max:50'],
            'pickup_location'=> ['required_if:delivery_type,pickup', 'nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'in:transfer,mercadopago'],
            'points_used'    => ['nullable', 'integer', 'min:0'],
        ]);

        /** @var User|null $user */
        $user = Auth::user();

        $cartItems = $user
            ? ProductCart::with('product')->where('user_id',$user->id)->get()
            : collect(session('cart',[]))->map(
                fn($qty,$id)=>(object)[
                    'product'=>Product::findOrFail($id),
                    'quantity'=>$qty
                ]
            );

        $subtotal = $cartItems->sum(
            fn($i)=>$i->quantity*$i->product->final_price
        );

        $pointsUsed = 0;

        if ($user && (int) $request->points_used > 0) {
            $pointsUsed = min((int) $request->points_used, (int) $subtotal);

            $reservedPoints = (int) Order::where('user_id', $user->id)
                ->where('estado_pago', 'pendiente')
                ->sum('points_used');

            $availablePoints = max(0, (int) $user->points_balance - $reservedPoints);

            if ($pointsUsed > $availablePoints) {
                return back()->withErrors('Puntos insuficientes');
            }
        }

        $isShipping = $request->delivery_type === 'shipping';

        $document = $request->document_type === 'rut'
            ? (string) $request->rut
            : (string) $request->passport;

        $requestedPayment = (string) $request->payment_method;

        if ($requestedPayment === 'mercadopago' && blank(config('mercadopago.access_token'))) {
            $requestedPayment = 'transfer';
        }

        $paymentMethod = match ($requestedPayment) {
            'transfer' => 'transferencia',
            default => 'mercadopago',
        };

        $orderNumber = 'ORD-' . now()->timestamp . '-' . Str::upper(Str::random(6));

        try {
            $order = DB::transaction(function () use (
                $user,
                $request,
                $cartItems,
                $subtotal,
                $pointsUsed,
                $isShipping,
                $document,
                $paymentMethod,
                $orderNumber
            ) {
                $order = Order::create([
                    'user_id'     => $user?->id,
                    'is_guest'    => !$user,
                    'order_number' => $orderNumber,
                    'email'       => $request->email,
                    'nombres'     => $request->first_name,
                    'apellidos'   => $request->last_name,
                    'telefono'    => $request->phone,
                    'documento'   => $document,
                    'tipo_envio'  => $isShipping ? 'despacho' : 'retiro',
                    'comuna'      => $isShipping ? $request->commune : null,
                    'calle'       => $isShipping ? $request->street : null,
                    'numero'      => $isShipping ? $request->number : null,
                    'extra'       => $isShipping ? $request->extra : null,
                    'codigo_postal' => $isShipping ? $request->postal_code : null,
                    'local_retiro'  => $isShipping ? null : $request->pickup_location,
                    'metodo_pago' => $paymentMethod,
                    'estado_pago' => 'pendiente',
                    'subtotal'    => (int) $subtotal,
                    'points_used' => (int) $pointsUsed,
                    'total'       => (int) $subtotal - (int) $pointsUsed,
                ]);

                foreach ($cartItems as $item) {
                    $product = Product::whereKey($item->product->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \Exception('Producto no encontrado');
                    }

                    if (!is_null($product->product_quantity)) {
                        $available = (int) $product->product_quantity;
                        $requested = (int) $item->quantity;

                        if ($requested > $available) {
                            throw new \Exception('Stock insuficiente para: ' . $product->product_title);
                        }

                        $product->decrement('product_quantity', $requested);
                    }

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $item->quantity,
                        'price'      => $product->final_price,
                        'subtotal'   => $item->quantity * $product->final_price,
                    ]);
                }

                // Opción A: los puntos se reservan en la orden (points_used)
                // y se descuentan recién cuando el pago se aprueba.

                return $order;
            });
        } catch (\Throwable $e) {
            return back()->withErrors('No se pudo procesar el checkout: ' . $e->getMessage());
        }

        if ($user) {
            ProductCart::where('user_id', $user->id)->delete();
        } else {
            session()->forget('cart');
        }

        session(['order_id' => $order->id]);

        try {
            Mail::to($order->email)->send(new OrderCreatedMail($order));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($requestedPayment === 'transfer') {
            return redirect()->route('payment.transfer', $order);
        }

        return redirect()->route('mercadopago.init');
    }
}
