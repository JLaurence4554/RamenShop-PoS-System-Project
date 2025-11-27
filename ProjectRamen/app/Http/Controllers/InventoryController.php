<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Addon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        // Apply filters
        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('category')) {
            $query->category($request->category);
        }

        if ($request->has('status')) {
            switch ($request->status) {
                case 'low-stock':
                    $query->lowStock();
                    break;
                case 'out-of-stock':
                    $query->outOfStock();
                    break;
                case 'in-stock':
                    $query->inStock();
                    break;
            }
        }

        $items = $query->orderBy('name')->get();
        $addons = Addon::with('inventoryItem')->get();

        // Calculate stats
        $stats = [
            'total_items' => InventoryItem::count(),
            'low_stock' => InventoryItem::lowStock()->count(),
            'out_of_stock' => InventoryItem::outOfStock()->count(),
            'total_value' => InventoryItem::sum(\DB::raw('quantity * unit_price'))
        ];

        return view('inventory.index', compact('items', 'stats', 'addons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'min_stock' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255'
        ]);

        $item = InventoryItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item added successfully!',
            'item' => $item
        ]);
    }

    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'min_stock' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255'
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully!',
            'item' => $item
        ]);
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully!'
        ]);
    }

    public function restock(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'add_quantity' => 'required|numeric|min:0.01'
        ]);

        $item->quantity += $validated['add_quantity'];
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Item restocked successfully!',
            'item' => $item
        ]);
    }

    public function bulkRestock()
    {
        $lowStockItems = InventoryItem::where(function($query) {
            $query->whereRaw('quantity <= min_stock')
                  ->orWhere('quantity', 0);
        })->get();

        foreach ($lowStockItems as $item) {
            $item->quantity = $item->min_stock * 2; // Restock to 2x minimum
            $item->save();
        }

        return response()->json([
            'success' => true,
            'message' => count($lowStockItems) . ' items restocked successfully!',
            'count' => count($lowStockItems)
        ]);
    }

    public function getItem(InventoryItem $item)
    {
        return response()->json([
            'success' => true,
            'item' => $item
        ]);
    }
}