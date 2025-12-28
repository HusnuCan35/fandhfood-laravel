<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::latest()->get();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Table::create([
            'name' => $request->name,
            'qr_code_path' => null,
            'status' => true,
        ]);

        return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        return view('admin.tables.show', compact('table'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $table->update([
            'name' => $request->name,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla silindi.');
    }
}
