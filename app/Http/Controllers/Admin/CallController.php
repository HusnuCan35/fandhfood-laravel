<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableCall;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index()
    {
        $calls = TableCall::with('table')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.calls.index', compact('calls'));
    }

    public function complete(TableCall $call)
    {
        $call->update(['status' => 'completed']);
        return back()->with('success', 'Talep tamamlandı.');
    }
}
