<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = OrderHistory::latest()->get()->map(function ($history) {
            if (is_string($history->items)) {
                $itemsArray = [];
                $items = explode(',', $history->items);

                foreach ($items as $itemStr) {
                    if (empty($itemStr)) continue;

                    $parts = explode(':', $itemStr);

                    // Skip invalid item format
                    if (count($parts) < 3) continue;

                    [$name, $qty, $price] = $parts;

                    $itemsArray[] = [
                        'name' => trim($name),
                        'qty' => (int) $qty,
                        'price' => (float) $price,
                    ];
                }

                $history->items = $itemsArray;
            }

            return $history;
        });

        return view('history.index', compact('histories'));
    }
}
