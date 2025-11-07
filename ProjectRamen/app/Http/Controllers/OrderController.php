<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'order_type' => 'required|string',
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        // Convert the items array to a string: "Ramen:2:80,Sushi:1:50"
        $itemsString = collect($validated['items'])->map(function ($item) {
            return "{$item['name']}:{$item['qty']}:{$item['price']}";
        })->implode(',');

        // Save the record
        OrderHistory::create([
            'order_type' => $validated['order_type'],
            'items' => $itemsString,
            'total' => $validated['total'],
        ]);

        return redirect()->route('history.index')->with('success', 'Order saved!');
    }
}
