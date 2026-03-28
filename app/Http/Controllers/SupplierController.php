<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function show(Supplier $supplier)
    {
        return redirect()->route('suppliers.edit', $supplier);
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
