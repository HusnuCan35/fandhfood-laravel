<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::middleware('auth')->prefix('profil')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/sifre', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Address Routes (AJAX)
Route::middleware('auth')->prefix('adres')->group(function () {
    Route::get('/', [AddressController::class, 'index'])->name('address.index');
    Route::post('/', [AddressController::class, 'store'])->name('address.store');
    Route::put('/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::patch('/{address}/varsayilan', [AddressController::class, 'setDefault'])->name('address.setDefault');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/giris', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/giris', [AuthController::class, 'login']);
    Route::get('/kayit', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/kayit', [AuthController::class, 'register']);
});

Route::post('/cikis', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Cart Routes (AJAX)
Route::middleware('auth')->prefix('sepet')->group(function () {
    Route::post('/ekle', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/popup', [CartController::class, 'getCartPopup'])->name('cart.popup');
    Route::get('/siparis', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/siparis', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
    Route::post('/kupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::delete('/kupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    // Wildcard routes must come LAST
    Route::patch('/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// Product Options Popup (AJAX) - no auth required to view options
Route::get('/urun/{product}/secenekler', [CartController::class, 'getProductOptions'])->name('product.options');

// Comment Routes (AJAX)
Route::post('/yorum/{comment}/begeni', [CommentController::class, 'like'])->name('comment.like');
Route::post('/yorum/{comment}/begenme', [CommentController::class, 'dislike'])->name('comment.dislike');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);
    Route::resource('users', AdminUserController::class)->only(['index', 'show']);
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::post('users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
    Route::resource('coupons', AdminCouponController::class)->except(['create', 'edit', 'show']);
    Route::resource('campaigns', AdminCampaignController::class)->except(['create', 'edit', 'show']);
});
