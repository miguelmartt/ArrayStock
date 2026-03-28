<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::query()
            ->with(['product', 'user'])
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->from, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($request->to, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $products = Product::orderBy('name')->get();

        return view('stock-movements.index', compact('movements', 'products'));
    }

    public function create()
    {
        $products = Product::where('active', true)->orderBy('name')->get();

        return view('stock-movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entry,exit,adjustment',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $previousStock = $product->stock;

        $newStock = match ($validated['type']) {
            'entry' => $previousStock + $validated['quantity'],
            'exit' => $previousStock - $validated['quantity'],
            'adjustment' => $validated['quantity'],
        };

        if ($validated['type'] === 'exit' && $validated['quantity'] > $previousStock) {
            return back()->withErrors([
                'quantity' => 'La cantidad a retirar no puede exceder el stock actual (' . $previousStock . ').',
            ])->withInput();
        }

        DB::transaction(function () use ($validated, $product, $previousStock, $newStock) {
            StockMovement::create([
                'product_id' => $validated['product_id'],
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'reason' => $validated['reason'],
            ]);

            $product->update(['stock' => $newStock]);
        });

        return redirect()->route('stock-movements.index')
            ->with('success', 'Movimiento de stock registrado correctamente.');
    }
}
