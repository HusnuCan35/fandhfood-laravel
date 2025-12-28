<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\Request;

class AllergenController extends Controller
{
    public function index()
    {
        $allergens = Allergen::all();
        return view('admin.allergens.index', compact('allergens'));
    }

    public function create()
    {
        return view('admin.allergens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        Allergen::create($request->all());

        return redirect()->route('admin.allergens.index')->with('success', 'Alerjen başarıyla eklendi.');
    }

    public function edit(Allergen $allergen)
    {
        return view('admin.allergens.edit', compact('allergen'));
    }

    public function update(Request $request, Allergen $allergen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $allergen->update($request->all());

        return redirect()->route('admin.allergens.index')->with('success', 'Alerjen başarıyla güncellendi.');
    }

    public function destroy(Allergen $allergen)
    {
        $allergen->delete();
        return redirect()->route('admin.allergens.index')->with('success', 'Alerjen başarıyla silindi.');
    }
}
