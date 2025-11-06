<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SaleController;
use App\Models\Sale;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [SaleController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/order', function () {
    $products = Product::all(); 
    return view('order.order', compact('products'));
})->middleware(['auth', 'verified'])->name('order.order');

Route::middleware('auth')->group(function () {

    Route::get('/order-dates', [SaleController::class, 'getOrderDates'])->name('order.dates');
    Route::get('/sales/by-date/{date}', [SaleController::class, 'getOrdersByDate'])->name('sales.byDate');

    Route::post('/save-sale', [SaleController::class, 'store'])->name('save.sale');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/{employee}/attendance', [EmployeeController::class, 'markAttendance'])->name('employees.attendance');

    //Crud routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}/delete', [ProductController::class, 'delete'])->name('product.delete');

    //Login & register Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
