<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class TournamentAdminController extends Controller
{
    public function index()
    {
        $tournaments = Product::query()
            ->where('is_tournament', true)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.events.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.tournaments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_title' => ['required', 'string', 'max:255'],
            'product_description' => ['nullable', 'string'],
            'product_quantity' => ['required', 'integer', 'min:0'],
            'product_price' => ['required', 'numeric', 'min:0'],
            'product_category' => ['nullable', 'string', 'max:255'],
            'sale_channel' => ['required', 'in:web,store,both'],
            'product_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $product = new Product();
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->sale_channel = $request->sale_channel;
        $product->is_tournament = true;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $product->product_image = $imagename;
        }

        $product->save();

        return redirect()->route('admin.events.tournaments.index')
            ->with('success', 'Torneo publicado exitosamente.');
    }

    public function edit(Product $tournament)
    {
        if (!$tournament->is_tournament) {
            abort(404);
        }

        $categories = Category::all();
        return view('admin.events.tournaments.edit', compact('tournament', 'categories'));
    }

    public function update(Request $request, Product $tournament)
    {
        if (!$tournament->is_tournament) {
            abort(404);
        }

        $request->validate([
            'product_title' => ['required', 'string', 'max:255'],
            'product_description' => ['nullable', 'string'],
            'product_quantity' => ['required', 'integer', 'min:0'],
            'product_price' => ['required', 'numeric', 'min:0'],
            'product_category' => ['nullable', 'string', 'max:255'],
            'sale_channel' => ['required', 'in:web,store,both'],
            'product_image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $tournament->product_title = $request->product_title;
        $tournament->product_description = $request->product_description;
        $tournament->product_quantity = $request->product_quantity;
        $tournament->product_price = $request->product_price;
        $tournament->product_category = $request->product_category;
        $tournament->sale_channel = $request->sale_channel;
        $tournament->is_tournament = true;

        if ($request->boolean('remove_image') && $tournament->product_image) {
            $old = public_path('products/' . $tournament->product_image);
            if (file_exists($old)) {
                unlink($old);
            }
            $tournament->product_image = null;
        }

        if ($request->hasFile('product_image')) {
            if ($tournament->product_image) {
                $old = public_path('products/' . $tournament->product_image);
                if (file_exists($old)) {
                    unlink($old);
                }
            }

            $image = $request->file('product_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $tournament->product_image = $imagename;
        }

        $tournament->save();

        return redirect()->route('admin.events.tournaments.index')
            ->with('success', 'Torneo actualizado exitosamente.');
    }

    public function unpublish(Product $tournament)
    {
        if (!$tournament->is_tournament) {
            abort(404);
        }

        $tournament->product_quantity = 0;
        $tournament->is_tournament = true;
        $tournament->save();

        return redirect()->route('admin.events.tournaments.index')
            ->with('success', 'Torneo despublicado (cupos en 0).');
    }

    public function destroy(Product $tournament)
    {
        if (!$tournament->is_tournament) {
            abort(404);
        }

        $hasOrderItems = OrderItem::query()
            ->where('product_id', $tournament->id)
            ->exists();

        if ($hasOrderItems) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar este torneo porque ya tiene órdenes asociadas. Puedes dejar cupos (stock) en 0 para despublicarlo.');
        }

        if ($tournament->product_image) {
            $old = public_path('products/' . $tournament->product_image);
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $tournament->delete();

        return redirect()->route('admin.events.tournaments.index')
            ->with('success', 'Torneo eliminado exitosamente.');
    }
}
