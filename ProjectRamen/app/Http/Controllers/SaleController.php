<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class SaleController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ordered' => 'required|integer',
            'full_salary' => 'required|numeric',
        ]);

        Sale::create($validated);

        return response()->json(['message' => 'Sale saved successfully']);
    }

    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $currentSale = Sale::whereDate('created_at', $today)
            ->selectRaw('SUM(ordered) as ordered, SUM(full_salary) as full_salary')
            ->first();

        $lastSale = Sale::whereDate('created_at', $yesterday)
            ->selectRaw('SUM(ordered) as ordered, SUM(full_salary) as full_salary')
            ->first();

        return view('dashboard', compact('currentSale', 'lastSale'));
    }

    public function getOrderDates()
    {
        return response()->json(
            Sale::selectRaw('DATE(created_at) as date')
                ->groupBy('date')
                ->orderByDesc('date')
                ->get()
        );
    }

    public function getOrdersByDate($date)
    {
        return response()->json(
            Sale::whereDate('created_at', $date)->get()
        );
    }

}
