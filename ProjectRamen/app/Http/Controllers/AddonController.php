<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::with('inventoryItem')->get();
        $inventoryItems = InventoryItem::all();
        return response()->json(['success' => true, 'addons' => $addons, 'inventoryItems' => $inventoryItems]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'inventory_item_id' => 'nullable|exists:inventory_items,id',
        ]);

        $addon = Addon::create($validated);

        return response()->json(['success' => true, 'message' => 'Add-on created successfully', 'addon' => $addon], 201);
    }

    public function show(Addon $addon)
    {
        return response()->json(['success' => true, 'addon' => $addon->load('inventoryItem')]);
    }

    public function update(Request $request, Addon $addon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'inventory_item_id' => 'nullable|exists:inventory_items,id',
        ]);

        $addon->update($validated);

        return response()->json(['success' => true, 'message' => 'Add-on updated successfully', 'addon' => $addon]);
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();
        return response()->json(['success' => true, 'message' => 'Add-on deleted successfully']);
    }
}
