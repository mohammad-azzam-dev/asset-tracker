<?php

namespace App\Http\Controllers;

use App\Models\StockPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockPurchaseController extends Controller
{
    public function index()
    {
        $purchases = Auth::user()->stockPurchases()->latest()->get();

        return view('purchases.index', compact('purchases'));
    }

    public function dashboard()
    {
        $purchases = Auth::user()->stockPurchases()->latest()->get();

        $totals = [
            'gold' => $purchases->where('stock_type', 'gold')->sum('total_value'),
            'silver' => $purchases->where('stock_type', 'silver')->sum('total_value'),
        ];

        $counts = [
            'gold' => $purchases->where('stock_type', 'gold')->count(),
            'silver' => $purchases->where('stock_type', 'silver')->count(),
            'total' => $purchases->count(),
        ];

        $quantities = [
            'gold' => $purchases->where('stock_type', 'gold')->sum('quantity'),
            'silver' => $purchases->where('stock_type', 'silver')->sum('quantity'),
        ];

        return view('dashboard', compact('purchases', 'totals', 'counts', 'quantities'));
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_type' => 'required|in:gold,silver',
            'purchase_price' => 'required|numeric|min:0.01',
            'quantity' => 'required|numeric|min:0.0001',
            'unit' => 'required|string|max:20',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        Auth::user()->stockPurchases()->create($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase added successfully!');
    }

    public function edit(StockPurchase $purchase)
    {
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }

        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, StockPurchase $purchase)
    {
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'stock_type' => 'required|in:gold,silver',
            'purchase_price' => 'required|numeric|min:0.01',
            'quantity' => 'required|numeric|min:0.0001',
            'unit' => 'required|string|max:20',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $purchase->update($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully!');
    }

    public function destroy(StockPurchase $purchase)
    {
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }

        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully!');
    }
}
