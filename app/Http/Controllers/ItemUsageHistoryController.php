<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemUsageHistory;
use App\Models\Restaurant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemUsageHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');  
        $restaurantFilter = $request->input('restaurant'); 
    
        $restaurants = Restaurant::all();  
    
        $itemUsageHistorys = ItemUsageHistory::with(['buyerUser', 'restaurant', 'item', 'sellerUser'])
            ->when($restaurantFilter, function($q) use ($restaurantFilter) {
                $q->whereHas('restaurant', function($q) use ($restaurantFilter) {
                    $q->where('id', $restaurantFilter);  
                });
            })
            ->where(function($q) use ($query) {
                $q->whereHas('buyerUser', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('restaurant', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('item', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('sellerUser', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(4);
    
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.itemUsageHistory.table', compact('itemUsageHistorys'))->render(),
                'pagination' => (string) $itemUsageHistorys->appends(['query' => $query, 'restaurant' => $restaurantFilter])->links(),
            ]);
        }
    
        return view('layouts.pages.itemUsageHistory.index', compact('itemUsageHistorys', 'restaurants', 'restaurantFilter'));
    }
    
    

    function addPage(){
        $items = Item::all();
        $users = User::all();
        $restaurants = Restaurant::all();
        $data = compact('items', 'users', 'restaurants');
        return view('layouts.pages.itemUsageHistory.add')->with($data);
    }

    function store(Request $request){

        $validated = $request->validate([
            'restaurant_id' => 'required',
            'item_id' => 'required',
            'buyer_user_id' => 'required',
            'quantity' => 'required',


        ]);

        try {
            // dd($request);
       $itemUsageHistory = new ItemUsageHistory();
       $itemUsageHistory->buyer_user_id = $request->buyer_user_id;
       $itemUsageHistory->seller_user_id = Auth::id();
       $itemUsageHistory->item_id = $request->item_id;
       $itemUsageHistory->restaurant_id = $request->restaurant_id;
       $itemUsageHistory->quantity = $request->quantity;
       $itemUsageHistory->save();
       return redirect()->back()->with('success', 'Information has been created successfully !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error: ');
        }

    }

    function edit($id){
        // dd('dataaa');
        $itemUsageHistorys = ItemUsageHistory::find($id);
        $items = Item::all();
        $users = User::all();
        $restaurants = Restaurant::all();
        $data = compact('items', 'users', 'restaurants', 'itemUsageHistorys');
        return view('layouts.pages.itemUsageHistory.edit')->with($data);
    }

    function update(Request $request, $id){

        $validated = $request->validate([
            'restaurant_id' => 'required',
            'item_id' => 'required',
            'buyer_user_id' => 'required',
            'quantity' => 'required',


        ]);

        try {
            // dd($request);

            $itemUsageHistory = ItemUsageHistory::find($id);
            // dd($itemUsageHistory);
            $itemUsageHistory->buyer_user_id = $request->buyer_user_id;
            $itemUsageHistory->seller_user_id = Auth::id();
            $itemUsageHistory->item_id = $request->item_id;
            $itemUsageHistory->restaurant_id = $request->restaurant_id;
            $itemUsageHistory->quantity = $request->quantity;
            $itemUsageHistory->save();
            return redirect()->back()->with('success', 'Information has been Updated successfully !');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'An error: ');
                }

    }

    function delete($id){
        // dd($id);
        $itemUsageHistory = ItemUsageHistory::find($id);
        if (!$itemUsageHistory) {
            return redirect()->back()->with('error', 'Restaurant not found.');
        }
        $itemUsageHistory->delete();
        return redirect()->back();
    }

}
