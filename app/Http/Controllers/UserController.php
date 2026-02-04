<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function cartCount(): int
    {
        return Auth::check()
            ? ProductCart::where('user_id', Auth::id())->count()
            : collect(session('cart', []))->sum();
    }

    public function home()
    {
        $productsQuery = Product::query()
            ->where('is_tournament', false)
            ->whereIn('sale_channel', ['web', 'both']);

        return view('index', [
            'products' => (clone $productsQuery)->latest()->take(8)->get(),
            'offers' => (clone $productsQuery)
                ->where('is_on_offer', true)
                ->orderByDesc('updated_at')
                ->take(4)
                ->get(),
            'categories' => Category::query()
                ->orderBy('category')
                ->take(8)
                ->get(),
            'count'    => $this->cartCount(),
        ]);
    }

    public function productDetails($id)
    {
        return view('product_details', [
            'product' => Product::findOrFail($id),
            'count'   => $this->cartCount(),
        ]);
    }

    public function viewAllProducts()
    {
        $query = Product::query()
            ->where('is_tournament', false)
            ->whereIn('sale_channel', ['web', 'both']);

        if (request('category')) {
            $query->where('product_category', request('category'));
        }

        return view('allproducts', [
            'products' => $query->latest()->paginate(12),
            'count'    => $this->cartCount(),
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = max(1, (int)$request->quantity);

        // Validación de stock (si el producto maneja stock)
        $stock = is_null($product->product_quantity) ? null : (int) $product->product_quantity;

        if (Auth::check()) {
            $item = ProductCart::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $id
            ]);

            $newQty = (int) $item->quantity + $qty;
            if (!is_null($stock) && $newQty > $stock) {
                return back()->withErrors('No hay stock suficiente.');
            }

            $item->quantity = $newQty;
            $item->save();
        } else {
            $cart = session('cart', []);

            $newQty = ((int) ($cart[$id] ?? 0)) + $qty;
            if (!is_null($stock) && $newQty > $stock) {
                return back()->withErrors('No hay stock suficiente.');
            }

            $cart[$id] = $newQty;
            session(['cart' => $cart]);
        }

        return back()->with('cart_message','Producto agregado');
    }

    public function cartProducts()
{
    if (Auth::check()) {
        // 🧑 Usuario
        $cart = ProductCart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cartJs = $cart->map(function ($item) {
            return [
                'id'       => $item->id,
                'title'    => $item->product->product_title,
                'price'    => $item->product->final_price,
                'quantity' => $item->quantity,
            ];
        });

    } else {
        // 👤 Invitado
        $cart = collect(session('cart', []))->map(function ($qty, $id) {
            return (object) [
                'id'       => $id,
                'product'  => Product::findOrFail($id),
                'quantity' => $qty,
            ];
        });

        $cartJs = $cart->map(function ($item) {
            return [
                'id'       => $item->id,
                'title'    => $item->product->product_title,
                'price'    => $item->product->final_price,
                'quantity' => $item->quantity,
            ];
        });
    }

    return view('viewcartproducts', [
        'cart'   => $cart,
        'cartJs' => $cartJs,
        'count'  => $cart->count(),
    ]);
}


    public function searchProducts(Request $request)
    {
        $query = Product::query()
            ->where('is_tournament', false)
            ->whereIn('sale_channel', ['web', 'both'])
            ->where('product_title', 'like', '%' . $request->query('query') . '%');

        return view('allproducts',[
            'products'=>$query->latest()->paginate(12),
            'count'=>$this->cartCount()
        ]);
    }

        public function removeCartProduct($id)
        {
            if (Auth::check()) {
                ProductCart::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->delete();

                return back()->with('cart_message', 'Producto eliminado');
            }

            $cart = session('cart', []);
            unset($cart[$id]);
            session(['cart' => $cart]);

            return back()->with('cart_message', 'Producto eliminado');
        }

        public function updateCart(Request $request, string $action, $id)
        {
            $allowed = ['increase', 'decrease'];
            if (!in_array($action, $allowed, true)) {
                return response()->json(['error' => 'Acción inválida'], 422);
            }

            if (Auth::check()) {
                $item = ProductCart::with('product')
                    ->where('user_id', Auth::id())
                    ->where('id', $id)
                    ->first();

                if (!$item || !$item->product) {
                    return response()->json(['error' => 'Ítem no encontrado'], 404);
                }

                $stock = is_null($item->product->product_quantity) ? null : (int) $item->product->product_quantity;
                $qty = (int) $item->quantity;

                if ($action === 'increase') {
                    if (!is_null($stock) && $qty >= $stock) {
                        return response()->json(['error' => 'Sin stock suficiente'], 422);
                    }
                    $qty++;
                } else {
                    $qty--;
                }

                if ($qty <= 0) {
                    $item->delete();
                    $total = ProductCart::with('product')
                        ->where('user_id', Auth::id())
                        ->get()
                        ->sum(fn ($i) => (int) $i->quantity * (int) $i->product->final_price);

                    return response()->json(['removed' => true, 'total' => $total]);
                }

                $item->update(['quantity' => $qty]);

                $total = ProductCart::with('product')
                    ->where('user_id', Auth::id())
                    ->get()
                    ->sum(fn ($i) => (int) $i->quantity * (int) $i->product->final_price);

                return response()->json([
                    'quantity' => $qty,
                    'total' => $total,
                ]);
            }

            // Invitado
            $cart = session('cart', []);
            $productId = (int) $id;
            $currentQty = (int) ($cart[$productId] ?? 0);

            if ($currentQty <= 0) {
                return response()->json(['error' => 'Ítem no encontrado'], 404);
            }

            $product = Product::find($productId);
            if (!$product) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $stock = is_null($product->product_quantity) ? null : (int) $product->product_quantity;

            if ($action === 'increase') {
                if (!is_null($stock) && $currentQty >= $stock) {
                    return response()->json(['error' => 'Sin stock suficiente'], 422);
                }
                $currentQty++;
            } else {
                $currentQty--;
            }

            if ($currentQty <= 0) {
                unset($cart[$productId]);
                session(['cart' => $cart]);

                $total = collect($cart)->sum(function ($qty, $pid) {
                    $p = Product::find($pid);
                    if (!$p) {
                        return 0;
                    }
                    return (int) $qty * (int) $p->final_price;
                });

                return response()->json(['removed' => true, 'total' => $total]);
            }

            $cart[$productId] = $currentQty;
            session(['cart' => $cart]);

            $total = collect($cart)->sum(function ($qty, $pid) {
                $p = Product::find($pid);
                if (!$p) {
                    return 0;
                }
                return (int) $qty * (int) $p->final_price;
            });

            return response()->json([
                'quantity' => $currentQty,
                'total' => $total,
            ]);
        }
}
