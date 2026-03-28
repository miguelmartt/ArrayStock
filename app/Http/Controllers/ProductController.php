<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->boolean('low_stock')) {
            $query->whereColumn('stock', '<=', 'min_stock');
        }

        $products = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku'         => 'nullable|string|max:100|unique:products,sku',
            'price'       => 'required|numeric|min:0',
            'cost'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
            'notes'       => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku'         => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'price'       => 'required|numeric|min:0',
            'cost'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
            'notes'       => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
