<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\ItemType;
use App\Models\Restaurant;
use App\Models\UsageHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');  // Get search input
        $restaurantFilter = $request->input('restaurant_id');  // Get selected restaurant filter
    
        $items = Item::query();
    
        if ($query) {
            $items->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
        }
    
        if ($restaurantFilter) {
            $items->where('restaurant_id', $restaurantFilter);  // Filter by selected restaurant
        }
    
        $items = $items->latest()->paginate(6);
        $restaurants = Restaurant::all();  // Get all restaurants for the dropdown
    
        if ($request->ajax()) {
            return response()->json([
                'card_data' => view('layouts.pages.items.items-card', compact('items'))->render(),
                'pagination' => (string) $items->appends(['query' => $query, 'restaurant_id' => $restaurantFilter])->links(),
            ]);
        }
    
        return view('layouts.pages.items.index', compact('items', 'restaurants'));
    }
    

    function addPage()
    {
        $itemtypes = ItemType::all();
        $restaurants = Restaurant::all();
        $data = compact('itemtypes', 'restaurants');
        return view('layouts.pages.items.add')->with($data);
    }

    function store(Request $request)
    {
        $validation = $request->all([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required',
            'image' => 'required',
            'item_type_id' => 'required',
            'restaurant_id' => 'required',
        ]);

        try {
            // Create new item
            $item = new Item();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->quantity = $request->quantity;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileInfo = $image->getClientOriginalName();
                $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
                $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
                $file_name = Auth::id() . '-' . time() . '.' . $extension;
                $image->move(public_path('task'), $file_name);
                $item->image = $file_name;
            }

            $item->item_type_id = $request->item_type_id;
            $item->restaurant_id = $request->restaurant_id;
            $item->user_id = Auth::id();
            $item->save();

            // Store item history
            $itemHistory = new ItemHistory();
            $itemHistory->name = $request->name;
            $itemHistory->description = $request->description;
            $itemHistory->quantity = $request->quantity;
            $itemHistory->item_type_id = $request->item_type_id;
            $itemHistory->restaurant_id = $request->restaurant_id;
            $itemHistory->user_id = Auth::id();
            $itemHistory->save();


            // Store usage history
            $usageHistory = new UsageHistory();
            $usageHistory->user_id = Auth::id();
            $usageHistory->restaurant_id = $request->restaurant_id;
            $usageHistory->item_id = $item->id;
            $usageHistory->quantity_used = 0;
            $usageHistory->stock_before = 0;
            $usageHistory->stock_after = $item->quantity;
            $usageHistory->save();
            // dd($usageHistory);


            return redirect()->back()->with('success', 'The information has been inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error found');
        }
    }

    function edit($id)
    {
        $items = Item::findOrFail($id);
        $itemtypes = ItemType::all();
        $restaurants = Restaurant::all();
        $data = compact('itemtypes', 'restaurants', 'items');
        return view('layouts.pages.items.edit')->with($data);
    }

    function update(Request $request, $id)
    {

        $validation = $request->all([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required',
            'item_type_id' => 'required',
            'restaurant_id' => 'required',
        ]);

        try {
            $item = Item::find($id);

            $stockBefore = $item->quantity;
            $newQuantity = $request->quantity;
            $quantityUsed = $stockBefore - $newQuantity;


            // Update item details
            $item->name = $request->name;
            $item->description = $request->description;
            $item->quantity = $newQuantity;
            $item->item_type_id = $request->item_type_id;
            $item->restaurant_id = $request->restaurant_id;
            $item->user_id = Auth::id();
            $item->save();

            // Store item history
            $itemHistory = new ItemHistory();
            $itemHistory->name = $request->name;
            $itemHistory->description = $request->description;
            $itemHistory->quantity = $newQuantity;
            $itemHistory->item_type_id = $request->item_type_id;
            $itemHistory->restaurant_id = $request->restaurant_id;
            $itemHistory->user_id = Auth::id();
            $itemHistory->save();

            if ($quantityUsed > $stockBefore) {
                return back()->with('error', 'Not enough stock available to reduce.');
            }

            if ($quantityUsed > 0 &&  $stockBefore >= $newQuantity) {

                $stockAfter = $newQuantity;

                // Store usage history
                $usageHistory = new UsageHistory();
                $usageHistory->user_id = Auth::id();
                $usageHistory->restaurant_id = $request->restaurant_id;
                $usageHistory->item_id = $item->id;
                $usageHistory->quantity_used = $quantityUsed;
                $usageHistory->stock_before = $stockBefore;
                $usageHistory->stock_after = $stockAfter;
                $usageHistory->save();
            }

            return redirect()->back()->with('success', 'The information has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error found');
        }
    }



    function delete($id)
    {
        // dd($id);
        $item = Item::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $item->delete();
        return redirect()->back();
    }

    public function history(Request $request)
    {
        $query = $request->input('query');
        $restaurantFilter = $request->input('restaurant'); // Get the selected restaurant
    
        $restaurants = Restaurant::all(); // Fetch all restaurants for the dropdown
    
        $itemshistory = ItemHistory::with(['restaurant', 'itemType', 'user'])
            ->when($restaurantFilter, function($q) use ($restaurantFilter) {
                $q->whereHas('restaurant', function($q) use ($restaurantFilter) {
                    $q->where('id', $restaurantFilter); // Filter by selected restaurant
                });
            })
            ->when($query, function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%"); // Search by item name
            })
            ->latest()
            ->paginate(5);
    
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.items.historysearch', compact('itemshistory'))->render(),
            ]);
        }
    
        return view('layouts.pages.items.history', compact('itemshistory', 'restaurants', 'restaurantFilter'));
    }
    
    
    
    

}
