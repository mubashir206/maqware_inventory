<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use App\Models\UsageHistory;
use Illuminate\Http\Request;

class UsageHistoryController extends Controller
{

    public function index(Request $request)
    {
        $restaurants = Restaurant::all();
        $usageHistorys = $this->filterUsageHistory($request);

        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.usageHistory.table', compact('usageHistorys'))->render(),
                'pagination' => (string) $usageHistorys->appends(['query' => $request->input('query'), 'restaurant' => $request->input('restaurant')])->links(),
            ]);
        }

        return view('layouts.pages.usageHistory.index', compact('usageHistorys', 'restaurants'));
    }

    private function filterUsageHistory(Request $request)
    {
        $searchQuery = $request->input('query'); // Capture search query
        $restaurantFilter = $request->input('restaurant'); // Capture restaurant filter

        // Build the query for usage history
        $usageHistorys = UsageHistory::with(['item', 'user', 'restaurant'])
            ->when($searchQuery, function ($q) use ($searchQuery) {
                $q->whereHas('item', function ($query) use ($searchQuery) {
                    $query->where('name', 'LIKE', "%{$searchQuery}%");
                })
                ->orWhereHas('user', function ($query) use ($searchQuery) {
                    $query->where('name', 'LIKE', "%{$searchQuery}%");
                });
            })
            ->when($restaurantFilter, function ($q) use ($restaurantFilter) {
                $q->whereHas('restaurant', function ($query) use ($restaurantFilter) {
                    $query->where('id', $restaurantFilter);
                });
            })
            ->latest()
            ->paginate(5);

        return $usageHistorys;
    }
}