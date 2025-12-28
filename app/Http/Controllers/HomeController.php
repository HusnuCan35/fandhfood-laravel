<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Branch;
use App\Models\Module;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage.
     */
    public function index(Request $request)
    {
        // Capture Table ID if present
        if ($request->has('table')) {
            return redirect()->route('qrmenu.index', ['table' => $request->table]);
        }

        // Get enabled modules
        $modules = Module::pluck('module_status', 'module_name')->toArray();

        // Get categories with products
        $categories = Category::active()
            ->ordered()
            ->with([
                'products' => function ($query) {
                    $query->active()->inStock();
                }
            ])
            ->get();

        // Get active comments
        $comments = Comment::active()
            ->with(['user', 'product'])
            ->orderBy('helpful', 'desc')
            ->take(6)
            ->get();

        // Get active branches
        $branches = Branch::active()->get();

        // Get user's cart if logged in
        $cart = null;
        $cartItems = collect();
        if (auth()->check()) {
            $cart = auth()->user()->cart;
            if ($cart) {
                $cartItems = $cart->items()->with(['product', 'options.productOption'])->get();
            }
        }

        return view('home', compact(
            'modules',
            'categories',
            'comments',
            'branches',
            'cart',
            'cartItems'
        ));
    }
}
