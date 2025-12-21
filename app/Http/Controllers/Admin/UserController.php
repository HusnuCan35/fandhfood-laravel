<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by admin
        if ($request->has('admin') && $request->admin !== '') {
            $query->where('is_admin', $request->admin);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders.items.product']);
        $totalSpent = $user->orders->sum('order_total');

        return view('admin.users.show', compact('user', 'totalSpent'));
    }

    public function toggleAdmin(User $user)
    {
        // Prevent removing own admin status
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi admin yetkinizi kaldıramazsınız!');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $message = $user->is_admin
            ? 'Kullanıcıya admin yetkisi verildi!'
            : 'Kullanıcının admin yetkisi kaldırıldı!';

        return back()->with('success', $message);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Kullanıcı bilgileri güncellendi!');
    }

    public function ban(Request $request, User $user)
    {
        // Prevent banning self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendinizi yasaklayamazsınız!');
        }

        $request->validate([
            'ban_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'is_banned' => true,
            'ban_reason' => $request->ban_reason,
            'banned_at' => now(),
        ]);

        return back()->with('success', 'Kullanıcı yasaklandı!');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_at' => null,
        ]);

        return back()->with('success', 'Kullanıcının yasağı kaldırıldı!');
    }
}
