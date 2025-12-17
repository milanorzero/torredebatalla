<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductCart;

class UserController extends Controller
{
    /* =====================================================
     |  MÉTODOS PRIVADOS
     ===================================================== */

    private function cartCount(): int
    {
        return Auth::check()
            ? ProductCart::where('user_id', Auth::id())->count()
            : 0;
    }

    private function cartTotal(): int
    {
        return ProductCart::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(fn ($item) =>
                $item->quantity * $item->product->product_price
            );
    }

    /* =====================================================
     |  VISTAS PRINCIPALES
     ===================================================== */

    public function index()
    {
        if (Auth::user()->user_type === 'admin') {
            return view('admin.dashboard');
        }

        return view('dashboard');
    }

    public function home()
    {
        return view('index', [
            'products' => Product::latest()->take(3)->get(),
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
        return view('allproducts', [
            'products' => Product::all(),
            'count'    => $this->cartCount(),
        ]);
    }

    /* =====================================================
     |  CARRITO
     ===================================================== */

    public function cartProducts()
    {
        $cart = ProductCart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('viewcartproducts', [
            'cart'  => $cart,
            'count' => $cart->count(),
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cartItem = ProductCart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        $currentQty   = $cartItem ? $cartItem->quantity : 0;
        $requestedQty = max(1, (int) $request->quantity);

        if ($currentQty + $requestedQty > $product->product_quantity) {
            return redirect()->back()->with(
                'cart_error',
                'No hay stock suficiente para agregar esa cantidad'
            );
        }

        ProductCart::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'product_id' => $id,
            ],
            [
                'quantity' => $currentQty + $requestedQty,
            ]
        );

        return redirect()->back()->with(
            'cart_message',
            'Producto agregado al carrito'
        );
    }

    public function removeCartProduct($id)
    {
        ProductCart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with(
            'cart_message',
            'Producto eliminado del carrito'
        );
    }

    /**
     * AJAX: aumentar / disminuir cantidad (+ / -)
     */
    public function updateCart($action, $id)
    {
        $cart = ProductCart::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('product')
            ->firstOrFail();

        // AUMENTAR
        if ($action === 'increase') {
            if ($cart->quantity >= $cart->product->product_quantity) {
                return response()->json([
                    'error' => 'No hay más stock disponible'
                ]);
            }
            $cart->quantity++;
        }

        // DISMINUIR
        if ($action === 'decrease') {
            $cart->quantity--;

            if ($cart->quantity <= 0) {
                $cart->delete();

                return response()->json([
                    'removed' => true,
                    'total'   => $this->cartTotal()
                ]);
            }
        }

        $cart->save();

        return response()->json([
            'quantity' => $cart->quantity,
            'total'    => $this->cartTotal()
        ]);
    }
    public function searchProducts(Request $request)
{
    $query = $request->input('query');

    $products = Product::where('product_title', 'like', "%{$query}%")
                        ->orWhere('product_description', 'like', "%{$query}%")
                        ->get();

    return view('allproducts', compact('products'));
}
}
