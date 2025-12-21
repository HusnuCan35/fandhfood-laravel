<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile page with user info and order history.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.index', compact('user', 'orders'));
    }

    /**
     * Update user profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil bilgileriniz güncellendi!',
            ]);
        }

        return back()->with('success', 'Profil bilgileriniz güncellendi!');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mevcut şifreniz yanlış!',
                ], 422);
            }
            return back()->withErrors(['current_password' => 'Mevcut şifreniz yanlış!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Şifreniz başarıyla değiştirildi!',
            ]);
        }

        return back()->with('success', 'Şifreniz başarıyla değiştirildi!');
    }
}
