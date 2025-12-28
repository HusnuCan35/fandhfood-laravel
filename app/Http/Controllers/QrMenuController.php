<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TableCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QrMenuController extends Controller
{
    /**
     * Display the QR Menu for a specific table.
     */
    public function index($tableId)
    {
        $table = Table::findOrFail($tableId);

        // Store table in session
        session(['table_id' => $table->id]);

        $categories = Category::active()
            ->ordered()
            ->with([
                'products' => function ($q) {
                    $q->active()->inStock()->with('allergens');
                }
            ])
            ->get();

        $cart = session()->get('qr_cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $activeOrders = $this->getActiveOrders($table->id);

        return view('qrmenu.index', compact('table', 'categories', 'cart', 'total', 'activeOrders'));
    }

    /**
     * Call a waiter or request bill.
     */
    public function callWaiter(Request $request)
    {
        $request->validate([
            'type' => 'required|in:waiter,bill'
        ]);

        $tableId = session('table_id');
        if (!$tableId) {
            return response()->json(['success' => false, 'message' => 'Masa oturumu bulunamadı.'], 403);
        }

        // Check if there's already a pending call of the same type for this table
        $existingCall = TableCall::where('table_id', $tableId)
            ->where('type', $request->type)
            ->where('status', 'pending')
            ->first();

        if ($existingCall) {
            return response()->json(['success' => true, 'message' => 'Talebiniz zaten iletildi, ekibimiz yolda.']);
        }

        TableCall::create([
            'table_id' => $tableId,
            'type' => $request->type,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Talebiniz iletildi.']);
    }

    /**
     * Get order status as JSON for AJAX polling.
     */
    public function getOrderStatus()
    {
        $tableId = session('table_id');
        if (!$tableId) {
            return response()->json(['success' => false], 403);
        }

        $orders = Order::where('table_id', $tableId)
            ->whereIn('order_status', ['pending', 'preparing', 'ready'])
            ->select('id', 'order_status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'status' => $order->order_status,
                    'time' => $order->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    /**
     * Get active orders for the current table session.
     */
    private function getActiveOrders($tableId)
    {
        return Order::where('table_id', $tableId)
            ->whereIn('order_status', ['pending', 'preparing', 'ready'])
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Add item to session cart.
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('qr_cart', []);

        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->product_price,
                'quantity' => 1,
                'image' => $product->product_image
            ];
        }

        session()->put('qr_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Ürün eklendi',
            'cartCount' => count($cart),
            'total' => $this->calculateTotal($cart)
        ]);
    }

    /**
     * Remove item from cart (decrease quantity or remove).
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('qr_cart', []);
        $id = $request->product_id;

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('qr_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
            'total' => $this->calculateTotal($cart),
            'cart' => $cart
        ]);
    }

    /**
     * Clear cart.
     */
    public function clearCart()
    {
        session()->forget('qr_cart');
        return redirect()->back();
    }

    /**
     * Place order for the table.
     */
    public function placeOrder(Request $request)
    {
        $tableId = session('table_id');
        if (!$tableId) {
            return redirect()->route('home')->with('error', 'Masa oturumu bulunamadı.');
        }

        $cart = session()->get('qr_cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Sepetiniz boş.');
        }

        $total = $this->calculateTotal($cart);

        $order = Order::create([
            'table_id' => $tableId,
            'user_id' => auth()->id(), // Use auth ID if logged in, otherwise null (now allowed)
            'order_total' => $total,
            'order_status' => 'pending',
            'payment_method' => 'cash', // Default for table orders usually, or could ask
            'payment_status' => 'pending',
            'discount_details' => [],
            'phone' => 'Masa Siparişi',
            'address' => 'Restoran İçi',
            'delivery_time_type' => 'now'
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('qr_cart');

        return redirect()->route('qrmenu.index', ['table' => $tableId])->with('success', 'Siparişiniz alındı! Masanıza yönlendiriliyor.');
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
