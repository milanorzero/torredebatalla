<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductCart;

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

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = max(1, (int)$request->quantity);

        if (Auth::check()) {
            $item = ProductCart::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $id
            ]);

            $item->quantity += $qty;
            $item->save();
        } else {
            $cart = session('cart', []);
            $cart[$id] = ($cart[$id] ?? 0) + $qty;
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
        return view('allproducts',[
            'products'=>Product::where('product_title','like','%'.$request->query.'%')->get(),
            'count'=>$this->cartCount()
        ]);
    }
}
