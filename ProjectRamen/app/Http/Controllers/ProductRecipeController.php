<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRecipe;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class ProductRecipeController extends Controller
{
    /**
     * Show all recipes for a product
     */
    public function index(Product $product)
    {
        $recipes = $product->recipes()->with('inventoryItem')->get();
        $inventoryItems = InventoryItem::all();
        
        return view('products.recipes.index', compact('product', 'recipes', 'inventoryItems'));
    }

    /**
     * Show form to add a new recipe
     */
    public function create(Product $product)
    {
        $inventoryItems = InventoryItem::all();
        return view('products.recipes.create', compact('product', 'inventoryItems'));
    }

    /**
     * Store a new recipe
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id|unique:product_recipes,inventory_item_id,NULL,id,product_id,' . $product->id,
            'quantity_needed' => 'required|numeric|min:0.01',
        ], [
            'inventory_item_id.unique' => 'This ingredient is already added to this product.',
        ]);

        $product->recipes()->create($validated);

        return redirect()
            ->route('products.recipes.index', $product)
            ->with('success', 'Recipe ingredient added successfully!');
    }

    /**
     * Show form to edit recipe
     */
    public function edit(Product $product, ProductRecipe $recipe)
    {
        // Ensure recipe belongs to product
        if ($recipe->product_id != $product->id) {
            abort(404);
        }

        $inventoryItems = InventoryItem::all();
        return view('products.recipes.edit', compact('product', 'recipe', 'inventoryItems'));
    }

    /**
     * Update recipe
     */
    public function update(Request $request, Product $product, ProductRecipe $recipe)
    {
        // Ensure recipe belongs to product
        if ($recipe->product_id != $product->id) {
            abort(404);
        }

        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id|unique:product_recipes,inventory_item_id,' . $recipe->id . ',id,product_id,' . $product->id,
            'quantity_needed' => 'required|numeric|min:0.01',
        ]);

        $recipe->update($validated);

        return redirect()
            ->route('products.recipes.index', $product)
            ->with('success', 'Recipe updated successfully!');
    }

    /**
     * Delete recipe
     */
    public function destroy(Product $product, ProductRecipe $recipe)
    {
        // Ensure recipe belongs to product
        if ($recipe->product_id != $product->id) {
            abort(404);
        }

        $ingredientName = $recipe->inventoryItem->name;
        $recipe->delete();

        return redirect()
            ->route('products.recipes.index', $product)
            ->with('success', "Ingredient '$ingredientName' removed from recipe!");
    }
}
