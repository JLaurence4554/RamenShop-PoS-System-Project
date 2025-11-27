<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRecipeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\InventoryController;
use App\Models\InventoryItem;
use App\Models\Sale;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [SaleController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes for cashier only (Order management)
Route::middleware(['auth', 'verified', 'role:cashier'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('order.order');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Routes for both cashier and admin (Order history and receipt)
Route::middleware(['auth', 'verified'])->group(function () {
    // Receipt route
    Route::get('/receipt', function (Request $request) {
        $orders = json_decode($request->query('orders'), true);
        $total = $request->query('total');
        $orderType = $request->query('orderType');
        return view('Order.receipt', compact('orders', 'total', 'orderType'));
    })->name('receipt');

    // History route (cashier views their orders, admin views all)
    Route::get('/order-dates', [SaleController::class, 'getOrderDates'])->name('order.dates');
    Route::get('/sales/by-date/{date}', [SaleController::class, 'getOrdersByDate'])->name('sales.byDate');
    Route::post('/save-sale', [SaleController::class, 'store'])->name('save.sale');
    
    // Profile routes (available to any authenticated user)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Inventory routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{item}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{item}/restock', [InventoryController::class, 'restock'])->name('inventory.restock');
    Route::post('/inventory/bulk-restock', [InventoryController::class, 'bulkRestock'])->name('inventory.bulkRestock');
    Route::get('/inventory/{item}/get', [InventoryController::class, 'getItem'])->name('inventory.get');

    // Addons routes
    Route::get('/addons', [AddonController::class, 'index'])->name('addons.index');
    Route::post('/addons', [AddonController::class, 'store'])->name('addons.store');
    Route::get('/addons/{addon}', [AddonController::class, 'show'])->name('addons.show');
    Route::put('/addons/{addon}', [AddonController::class, 'update'])->name('addons.update');
    Route::delete('/addons/{addon}', [AddonController::class, 'destroy'])->name('addons.destroy');

    // Employee routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/{employee}/attendance', [EmployeeController::class, 'markAttendance'])->name('employees.attendance');

    // Product routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}/delete', [ProductController::class, 'delete'])->name('product.delete');

    // Product Recipe routes
    Route::get('/product/{product}/recipes', [ProductRecipeController::class, 'index'])->name('products.recipes.index');
    Route::get('/product/{product}/recipes/create', [ProductRecipeController::class, 'create'])->name('products.recipes.create');
    Route::post('/product/{product}/recipes', [ProductRecipeController::class, 'store'])->name('products.recipes.store');
    Route::get('/product/{product}/recipes/{recipe}/edit', [ProductRecipeController::class, 'edit'])->name('products.recipes.edit');
    Route::put('/product/{product}/recipes/{recipe}', [ProductRecipeController::class, 'update'])->name('products.recipes.update');
    Route::delete('/product/{product}/recipes/{recipe}', [ProductRecipeController::class, 'destroy'])->name('products.recipes.destroy');

    
});

require __DIR__.'/auth.php';

// Dev-only impersonation route: use locally to open different sessions in multiple tabs/browsers.
// Example: /impersonate/2 will log you in as user with ID 2 and redirect to the dashboard.
// WARNING: REMOVE or PROTECT this route before deploying to production.
if (app()->environment('local')) {
    Route::get('/impersonate/{id}', function ($id) {
        \Illuminate\Support\Facades\Auth::loginUsingId($id);
        return redirect()->intended(route('dashboard'));
    })->name('dev.impersonate');
}
