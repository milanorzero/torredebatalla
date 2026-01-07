<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function create()
    {
        return view('admin.pos', [
            'users'    => User::orderBy('name')->get(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'products'    => 'required|array',
            'points_used' => 'nullable|integer|min:0',
        ]);

        $user = User::findOrFail($request->user_id);
        $pointsUsed = (int) $request->points_used;

        $subtotal = 0;
        foreach ($request->products as $productId => $qty) {
            $product = Product::find($productId);
            if ($product && $qty > 0) {
                $subtotal += $product->final_price * $qty;
            }
        }

        if ($pointsUsed > 0 && !$user->hasEnoughPoints($pointsUsed)) {
            return back()->withErrors('El cliente no tiene puntos suficientes.');
        }

        if ($pointsUsed > $subtotal) {
            $pointsUsed = $subtotal;
        }

        DB::transaction(function () use ($request, $user, $subtotal, $pointsUsed) {

            $order = Order::create([
                'user_id'     => $user->id,
                'is_guest'    => false,
                'tipo_envio'  => 'retiro',
                'metodo_pago' => 'store',
                'estado_pago' => 'pagado',
                'subtotal'    => $subtotal,
                'points_used' => $pointsUsed,
                'total'       => $subtotal - $pointsUsed,
            ]);

            foreach ($request->products as $productId => $qty) {
                if ($qty > 0) {
                    $product = Product::find($productId);
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $productId,
                        'quantity'   => $qty,
                        'price'      => $product->final_price,
                        'subtotal'   => $product->final_price * $qty,
                    ]);
                }
            }

            if ($pointsUsed > 0) {
                $user->decrement('points_balance', $pointsUsed);

                PointTransaction::create([
                    'user_id'      => $user->id,
                    'type'         => 'spent',
                    'channel'      => 'store',
                    'points'       => $pointsUsed,
                    'reason'       => 'Compra en tienda física',
                    'reference_id' => $order->id,
                ]);
            }
        });

        return redirect()
            ->route('admin.pos.create')
            ->with('success', 'Venta registrada correctamente');
    }
}