<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories',
            'category_icon' => 'nullable|string|max:255',
        ]);

        Category::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori oluşturuldu!']);
        }

        return back()->with('success', 'Kategori başarıyla oluşturuldu!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
            'category_icon' => 'nullable|string|max:255',
        ]);

        $category->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori güncellendi!']);
        }

        return back()->with('success', 'Kategori başarıyla güncellendi!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Bu kategoride ürünler var, silinemez!');
        }

        $category->delete();

        return back()->with('success', 'Kategori başarıyla silindi!');
    }
}
