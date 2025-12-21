<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemOption;
use App\Models\Product;
use App\Models\ProductOptionSetting;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Add product to cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500',
            'options' => 'nullable|array',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stokta yeterli ürün yok.',
            ], 400);
        }

        // Get or create cart
        $cart = auth()->user()->getOrCreateCart();

        // Check if same product with same options exists
        $existingItem = $this->findExistingCartItem($cart, $product->id, $request->options ?? []);

        if ($existingItem) {
            // Update quantity
            $existingItem->product_number += $request->quantity;
            $existingItem->save();
        } else {
            // Create new cart item
            DB::transaction(function () use ($cart, $product, $request) {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'product_number' => $request->quantity,
                    'product_note' => $request->note,
                ]);

                // Add selected options
                if ($request->options) {
                    foreach ($request->options as $optionId) {
                        CartItemOption::create([
                            'item_id' => $cartItem->id,
                            'option_id' => $optionId,
                        ]);
                    }
                }
            });
        }

        // Recalculate cart total
        $cart->recalculateTotal();

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepete eklendi!',
            'cart_count' => $cart->item_count,
            'cart_total' => $cart->total_price,
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $item)
    {
        // Verify ownership
        if ($item->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Yetkisiz işlem.'], 403);
        }

        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        if ($request->action === 'increase') {
            if ($item->product_number < $item->product->stock) {
                $item->product_number++;
                $item->save();
            }
        } else {
            if ($item->product_number > 1) {
                $item->product_number--;
                $item->save();
            } else {
                // Remove item if quantity is 1 and decreasing
                $item->options()->delete();
                $item->delete();
            }
        }

        $cart = $item->cart;
        $cart->recalculateTotal();

        return response()->json([
            'success' => true,
            'quantity' => $item->exists ? $item->product_number : 0,
            'cart_count' => $cart->item_count,
            'cart_total' => $cart->total_price,
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(CartItem $item)
    {
        // Verify ownership
        if ($item->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Yetkisiz işlem.'], 403);
        }

        $cart = $item->cart;

        $item->options()->delete();
        $item->delete();

        $cart->recalculateTotal();

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepetten kaldırıldı.',
            'cart_count' => $cart->item_count,
            'cart_total' => $cart->total_price,
        ]);
    }

    /**
     * Get product options popup HTML.
     */
    public function getProductOptions(Product $product)
    {
        $optionSettings = $product->optionSettings()->with('options')->get();

        return view('components.product-popup', compact('product', 'optionSettings'));
    }

    /**
     * Get cart popup HTML.
     */
    public function getCartPopup()
    {
        $cart = auth()->user()?->cart;
        $cartItems = $cart ? $cart->items()->with(['product', 'options.productOption'])->get() : collect();

        return view('components.cart-popup', compact('cart', 'cartItems'));
    }

    /**
     * Apply coupon code to cart.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $cart = auth()->user()->cart;
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Sepetiniz boş.'], 400);
        }

        $coupon = Discount::where('discount_code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Geçersiz kupon kodu.'], 400);
        }

        if (!$coupon->isValid()) {
            return response()->json(['success' => false, 'message' => 'Bu kupon kodu artık geçerli değil.'], 400);
        }

        if ($coupon->min_order > 0 && $cart->total_price < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum sipariş tutarı: ' . number_format($coupon->min_order, 2) . ' ₺'
            ], 400);
        }

        $discount = $coupon->calculateDiscount($cart->total_price);

        // Store coupon in session for checkout
        session([
            'applied_coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->discount_code,
                'discount' => $discount,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kupon uygulandı!',
            'discount' => $discount,
            'coupon_code' => $coupon->discount_code,
            'new_total' => $cart->total_price - $discount,
        ]);
    }

    /**
     * Remove applied coupon from cart.
     */
    public function removeCoupon()
    {
        $cart = auth()->user()->cart;
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Sepetiniz boş.'], 400);
        }

        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Kupon kaldırıldı.',
            'new_total' => $cart->total_price,
        ]);
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('home')->with('error', 'Sepetinizde ürün bulunmuyor.');
        }

        $cartItems = $cart->items()->with(['product', 'options.productOption'])->get();
        $cart->recalculateTotal();

        $appliedCoupon = session('applied_coupon');
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        $defaultAddress = $user->defaultAddress();

        return view('cart.checkout', compact('cart', 'cartItems', 'user', 'appliedCoupon', 'addresses', 'defaultAddress'));
    }

    /**
     * Place order from cart.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'nullable|exists:addresses,id',
            'address' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,card_at_door,meal_card',
            'note' => 'nullable|string|max:500',
            'leave_at_door' => 'nullable|boolean',
            'no_bell' => 'nullable|boolean',
            'eco_friendly' => 'nullable|boolean',
            'courier_note' => 'nullable|string|max:500',
            'delivery_time_type' => 'required|in:now,scheduled',
            'delivery_date' => 'nullable|date',
            'delivery_hour' => 'nullable|string|max:5',
        ]);

        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Sepetinizde ürün bulunmuyor.',
            ], 400);
        }

        // Get address from database or request
        $addressText = $request->address;
        if ($request->address_id) {
            $address = \App\Models\Address::find($request->address_id);
            if ($address && $address->user_id === $user->id) {
                $addressText = $address->getFormattedAddress();
            }
        }

        if (!$addressText) {
            return response()->json([
                'success' => false,
                'message' => 'Lütfen bir teslimat adresi seçin veya girin.',
            ], 400);
        }

        // Recalculate total
        $cart->recalculateTotal();

        // Gather discount details for order
        $discountDetails = [
            'campaigns' => [],
            'coupon' => null,
            'subtotal_before_discounts' => 0,
            'campaign_savings' => 0,
            'coupon_savings' => 0,
            'total_savings' => 0,
        ];

        // Calculate campaign discounts
        $subtotalBeforeDiscounts = 0;
        foreach ($cart->items as $item) {
            $product = $item->product;
            $originalPrice = $product->product_price * $item->product_number;
            $subtotalBeforeDiscounts += $originalPrice;

            if ($product->hasActiveCampaign()) {
                $campaigns = $product->getActiveCampaigns();
                foreach ($campaigns as $campaign) {
                    $saving = $originalPrice - ($product->getDiscountedPrice() * $item->product_number);
                    if (!isset($discountDetails['campaigns'][$campaign->id])) {
                        $discountDetails['campaigns'][$campaign->id] = [
                            'name' => $campaign->name,
                            'percent' => $campaign->discount_percent,
                            'savings' => 0,
                        ];
                    }
                    $discountDetails['campaigns'][$campaign->id]['savings'] += $saving;
                }
            }
        }

        $campaignSavings = array_sum(array_column($discountDetails['campaigns'], 'savings'));
        $discountDetails['subtotal_before_discounts'] = $subtotalBeforeDiscounts;
        $discountDetails['campaign_savings'] = $campaignSavings;

        // Apply coupon discount if exists
        $orderTotal = $cart->total_price;
        $appliedCoupon = session('applied_coupon');
        if ($appliedCoupon) {
            $orderTotal = max(0, $orderTotal - $appliedCoupon['discount']);
            $discountDetails['coupon'] = [
                'code' => $appliedCoupon['code'],
                'discount' => $appliedCoupon['discount'],
            ];
            $discountDetails['coupon_savings'] = $appliedCoupon['discount'];
        }

        $discountDetails['total_savings'] = $campaignSavings + ($appliedCoupon['discount'] ?? 0);

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'order_total' => $orderTotal,
            'discount_details' => $discountDetails,
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'address' => $addressText,
            'phone' => $request->phone,
            'note' => $request->note,
            'leave_at_door' => $request->boolean('leave_at_door'),
            'no_bell' => $request->boolean('no_bell'),
            'eco_friendly' => $request->boolean('eco_friendly'),
            'courier_note' => $request->courier_note,
            'delivery_time_type' => $request->delivery_time_type,
            'delivery_date' => $request->delivery_time_type === 'scheduled' ? $request->delivery_date : null,
            'delivery_hour' => $request->delivery_time_type === 'scheduled' ? $request->delivery_hour : null,
        ]);

        // Transfer cart items to order items
        foreach ($cart->items as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->product_name,
                'quantity' => $item->product_number,
                'price' => $item->product->product_price,
            ]);

            // Decrease stock
            $item->product->decrement('stock', $item->product_number);
        }

        // Clear cart and coupon session
        $cart->items()->each(function ($item) {
            $item->options()->delete();
        });
        $cart->items()->delete();
        $cart->update(['total_price' => 0, 'discount_id' => null]);
        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Siparişiniz alındı!',
            'order_id' => $order->id,
        ]);
    }

    /**
     * Find existing cart item with same options.
     */
    private function findExistingCartItem(Cart $cart, int $productId, array $options): ?CartItem
    {
        $cartItems = $cart->items()->where('product_id', $productId)->with('options')->get();

        sort($options);

        foreach ($cartItems as $item) {
            $itemOptions = $item->options->pluck('option_id')->sort()->values()->toArray();
            if ($itemOptions === $options) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Clear all items from cart.
     */
    public function clearCart()
    {
        $cart = auth()->user()->cart;
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Sepetiniz zaten boş.'], 400);
        }

        $cart->items()->each(function ($item) {
            $item->options()->delete();
        });
        $cart->items()->delete();
        $cart->update(['total_price' => 0, 'discount_id' => null]);
        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Sepetiniz boşaltıldı.',
        ]);
    }
}

