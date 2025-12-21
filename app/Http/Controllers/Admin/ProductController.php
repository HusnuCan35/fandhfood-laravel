<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla oluşturuldu!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla güncellendi!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla silindi!');
    }
}
