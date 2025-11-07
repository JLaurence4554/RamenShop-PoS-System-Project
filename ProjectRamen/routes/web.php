<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\OrderHistory;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/order', function () {
    $products = Product::all(); 
    return view('order.order', compact('products'));
})->middleware(['auth', 'verified'])->name('order.order');

Route::middleware('auth')->group(function () {

    //Crud routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}/delete', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])
         ->name('history.index');

    //Login & register Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/about', 'about')->name('about');

    Route::post('/save-order', function (Request $request) {
    // Validate like normal form
    $validated = $request->validate([
        'order_type' => 'required|string',
        'items' => 'required|array',
        'total' => 'required|numeric',
    ]);

    // Build a readable string for items (instead of JSON)
    $itemDescriptions = [];
    foreach ($request->items as $item) {
        $itemDescriptions[] = "{$item['name']} x {$item['qty']} (₱" . ($item['price'] * $item['qty']) . ")";
    }

    // Save as plain text
    OrderHistory::create([
        'order_type' => $request->order_type,
        'items' => implode(', ', $itemDescriptions),
        'total' => $request->total,
    ]);

    return redirect()->route('history.index')->with('success', 'Order saved successfully!');
    })->name('save-order');
});
require __DIR__.'/auth.php';
