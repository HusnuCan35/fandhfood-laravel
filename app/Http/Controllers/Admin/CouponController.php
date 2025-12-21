<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Discount::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'discount_code' => 'required|string|max:50|unique:discounts',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after:now',
            'status' => 'boolean',
        ]);

        $validated['discount_code'] = strtoupper($validated['discount_code']);
        $validated['status'] = $request->has('status');
        $validated['discount_percent'] = $validated['discount_percent'] ?? 0;
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['min_order'] = $validated['min_order'] ?? 0;

        Discount::create($validated);

        return back()->with('success', 'Kupon kodu oluşturuldu!');
    }

    public function update(Request $request, Discount $coupon)
    {
        $validated = $request->validate([
            'discount_code' => 'required|string|max:50|unique:discounts,discount_code,' . $coupon->id,
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'status' => 'boolean',
        ]);

        $validated['discount_code'] = strtoupper($validated['discount_code']);
        $validated['status'] = $request->has('status');
        $validated['discount_percent'] = $validated['discount_percent'] ?? 0;
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['min_order'] = $validated['min_order'] ?? 0;

        $coupon->update($validated);

        return back()->with('success', 'Kupon kodu güncellendi!');
    }

    public function destroy(Discount $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Kupon kodu silindi!');
    }
}
