<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TableCall;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get pending orders and calls count for notification polling.
     */
    public function check()
    {
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $pendingCalls = TableCall::where('status', 'pending')->count();

        return response()->json([
            'orders' => $pendingOrders,
            'calls' => $pendingCalls,
            'total' => $pendingOrders + $pendingCalls
        ]);
    }
}
