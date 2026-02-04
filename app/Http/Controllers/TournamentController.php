<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TournamentController extends Controller
{
    public function __invoke(Request $request): View
    {
        $products = Product::query()
            ->where('is_tournament', true)
            ->orWhere('product_category', 'like', '%torneo%')
            ->latest()
            ->get();

        $count = Auth::check()
            ? ProductCart::where('user_id', Auth::id())->count()
            : collect(session('cart', []))->count();

        return view('tournaments.index', [
            'products' => $products,
            'count' => $count,
        ]);
    }
}
