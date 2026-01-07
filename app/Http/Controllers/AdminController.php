<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    /* =========================
     | CATEGORÍAS
     ========================= */

    public function addCategory()
    {
        return view('admin.addcategory');
    }

    public function postAddCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        Category::create([
            'category' => $request->category
        ]);

        return redirect()->back()
            ->with('category_message', 'Categoria agregada exitosamente');
    }

    public function viewCategory()
    {
        $categories = Category::all();
        return view('admin.viewcategory', compact('categories'));
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->back()
            ->with('deletecategory_message', 'Categoria borrada exitosamente');
    }

    public function updateCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.updatecategory', compact('category'));
    }

    public function postupdateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'category' => $request->category
        ]);

        return redirect()->back()
            ->with('category_updated_message', 'Categoria actualizada exitosamente');
    }

    /* =========================
     | PRODUCTOS
     ========================= */

    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.addproduct', compact('categories'));
    }

    public function postAddProduct(Request $request)
    {
        $request->validate([
            'product_title'   => 'required',
            'product_quantity'=> 'required|integer|min:0',
            'product_price'   => 'required|numeric|min:0',
            'sale_channel'    => 'required|in:web,store,both',
        ]);

        $product = new Product();
        $product->product_title       = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity    = $request->product_quantity;
        $product->product_price       = $request->product_price;
        $product->product_category    = $request->product_category;
        $product->sale_channel        = $request->sale_channel;

        if ($request->hasFile('product_image')) {
            $image     = $request->file('product_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $product->product_image = $imagename;
        }

        $product->save();

        return redirect()->back()
            ->with('product_message', 'Producto agregado exitosamente');
    }

    public function viewProduct()
    {
        $products = Product::paginate(5);
        return view('admin.viewproduct', compact('products'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->product_image) {
            $path = public_path('products/' . $product->product_image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $product->delete();

        return redirect()->back()
            ->with('deleteproduct_message', 'Producto borrado exitosamente');
    }

    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.updateproduct', compact('product', 'categories'));
    }

    public function postUpdateproduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->product_title       = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity    = $request->product_quantity;
        $product->product_price       = $request->product_price;
        $product->product_category    = $request->product_category;
        $product->sale_channel        = $request->sale_channel;

        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                $old = public_path('products/' . $product->product_image);
                if (file_exists($old)) unlink($old);
            }

            $image = $request->file('product_image');
            $name  = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $name);
            $product->product_image = $name;
        }

        $product->save();

        return redirect()->back()
            ->with('product_updated_message', 'Producto actualizado exitosamente');
    }
}
