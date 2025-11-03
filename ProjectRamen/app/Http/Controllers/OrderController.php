<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Pass them to the order view
        return view('order.order', compact('products'));
    }
}
