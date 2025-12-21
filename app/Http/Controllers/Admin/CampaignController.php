<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->get();
        $products = Product::select('id', 'product_name')->get();
        $categories = Category::select('id', 'category_name')->get();

        return view('admin.campaigns.index', compact('campaigns', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|integer|min:1|max:100',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_flash' => 'boolean',
            'status' => 'boolean',
        ]);

        $validated['is_flash'] = $request->has('is_flash');
        $validated['status'] = $request->has('status');

        Campaign::create($validated);

        return back()->with('success', 'Kampanya oluşturuldu!');
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|integer|min:1|max:100',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_flash' => 'boolean',
            'status' => 'boolean',
        ]);

        $validated['is_flash'] = $request->has('is_flash');
        $validated['status'] = $request->has('status');
        $validated['product_ids'] = $request->product_ids ?? null;
        $validated['category_ids'] = $request->category_ids ?? null;

        $campaign->update($validated);

        return back()->with('success', 'Kampanya güncellendi!');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Kampanya silindi!');
    }
}
