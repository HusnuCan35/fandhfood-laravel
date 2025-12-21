<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Get all addresses for current user.
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses->map(fn($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'type' => $a->address_type,
                'type_label' => $a->getTypeLabel(),
                'type_icon' => $a->getTypeIcon(),
                'full_address' => $a->full_address,
                'formatted' => $a->getFormattedAddress(),
                'district' => $a->district,
                'city' => $a->city,
                'building_no' => $a->building_no,
                'floor' => $a->floor,
                'apartment_no' => $a->apartment_no,
                'directions' => $a->directions,
                'is_default' => $a->is_default,
            ]),
        ]);
    }

    /**
     * Store a new address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'address_type' => 'required|in:home,work,other',
            'full_address' => 'required|string|max:500',
            'district' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'building_no' => 'nullable|string|max:20',
            'floor' => 'nullable|string|max:10',
            'apartment_no' => 'nullable|string|max:20',
            'directions' => 'nullable|string|max:500',
            'is_default' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        // If setting as default, unset others
        if ($request->boolean('is_default')) {
            $user->addresses()->update(['is_default' => false]);
        }

        // If first address, make it default
        $isFirst = $user->addresses()->count() === 0;

        $address = $user->addresses()->create([
            'title' => $request->title,
            'address_type' => $request->address_type,
            'full_address' => $request->full_address,
            'district' => $request->district,
            'city' => $request->city,
            'building_no' => $request->building_no,
            'floor' => $request->floor,
            'apartment_no' => $request->apartment_no,
            'directions' => $request->directions,
            'is_default' => $request->boolean('is_default') || $isFirst,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Adres eklendi!',
            'address' => [
                'id' => $address->id,
                'title' => $address->title,
                'type' => $address->address_type,
                'type_label' => $address->getTypeLabel(),
                'type_icon' => $address->getTypeIcon(),
                'formatted' => $address->getFormattedAddress(),
                'is_default' => $address->is_default,
            ],
        ]);
    }

    /**
     * Update an address.
     */
    public function update(Request $request, Address $address)
    {
        // Verify ownership
        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Yetkisiz işlem.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:50',
            'address_type' => 'required|in:home,work,other',
            'full_address' => 'required|string|max:500',
            'district' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'building_no' => 'nullable|string|max:20',
            'floor' => 'nullable|string|max:10',
            'apartment_no' => 'nullable|string|max:20',
            'directions' => 'nullable|string|max:500',
        ]);

        $address->update([
            'title' => $request->title,
            'address_type' => $request->address_type,
            'full_address' => $request->full_address,
            'district' => $request->district,
            'city' => $request->city,
            'building_no' => $request->building_no,
            'floor' => $request->floor,
            'apartment_no' => $request->apartment_no,
            'directions' => $request->directions,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Adres güncellendi!',
        ]);
    }

    /**
     * Delete an address.
     */
    public function destroy(Address $address)
    {
        // Verify ownership
        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Yetkisiz işlem.'], 403);
        }

        // Check if this is the last address
        $addressCount = auth()->user()->addresses()->count();
        if ($addressCount <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Son adresinizi silemezsiniz! Önce yeni bir adres ekleyin.',
            ], 400);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted was default, set first remaining as default
        if ($wasDefault) {
            $firstAddress = auth()->user()->addresses()->first();
            if ($firstAddress) {
                $firstAddress->update(['is_default' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Adres silindi!',
        ]);
    }

    /**
     * Set address as default.
     */
    public function setDefault(Address $address)
    {
        // Verify ownership
        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Yetkisiz işlem.'], 403);
        }

        // Unset all others
        auth()->user()->addresses()->update(['is_default' => false]);

        // Set this as default
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Varsayılan adres güncellendi!',
        ]);
    }
}
