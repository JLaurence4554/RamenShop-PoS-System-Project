<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductRecipe;
use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();

        return view('order.order', compact('products'));
    }
    

    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                // Validate request
                $validated = $request->validate([
                    'items' => 'required|array',
                    'items.*.product_id' => 'required|exists:product,id',
                    'items.*.quantity' => 'required|integer|min:1',
                    'items.*.price' => 'required|numeric|min:0',
                    'items.*.subtotal' => 'required|numeric|min:0',
                    'total' => 'required|numeric|min:0',
                ]);

                // Create order
                $order = Order::create([
                    'total' => $validated['total'],
                ]);

                // Process each item in the order
                foreach ($validated['items'] as $item) {
                    // Create order item
                    OrderItem::create([
                        'order_id'    => $order->id,
                        'product_id'  => $item['product_id'],
                        'quantity'    => $item['quantity'],
                        'price'       => $item['price'],
                        'subtotal'    => $item['subtotal'],
                    ]);

                    // Get all recipes for this product
                    $recipes = ProductRecipe::where('product_id', $item['product_id'])->get();

                    // Deduct inventory for each recipe ingredient
                    foreach ($recipes as $recipe) {
                        $ingredient = InventoryItem::find($recipe->inventory_item_id);

                        if (!$ingredient) {
                            continue;
                        }

                        // Calculate total quantity to deduct
                        $deductQty = $recipe->quantity_needed * $item['quantity'];

                        // Check if enough stock exists
                        if ($ingredient->quantity < $deductQty) {
                            throw new \Exception("Insufficient stock for {$ingredient->name}. Required: {$deductQty}, Available: {$ingredient->quantity}");
                        }

                        // Deduct from inventory
                        $ingredient->decrement('quantity', $deductQty);
                    }
                }

                return response()->json(['success' => true, 'order_id' => $order->id], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

}

