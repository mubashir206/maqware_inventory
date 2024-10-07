<?php

namespace App\Http\Controllers;

use App\Mail\ZeroItems;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\ResturantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResturantItemController extends Controller
{
    public function index(Request $request, $id)
    {
        $query = $request->input('query');
    
        // Search for items based on the query and restaurant_id
        $items = Item::where('restaurant_id', '=', $id)
            ->where('name', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(4);
    
        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.restaurantitem.table', compact('items'))->render(),
                'pagination' => (string) $items->appends(['query' => $query])->links(),
            ]);
        }
    
        $data = compact('id', 'items');
        return view('layouts.pages.restaurantitem.index')->with($data);
    }
    

    function addPage($id)
    {
        $restaurants = Restaurant::where('id', '=', $id)->get();
        $items = Item::all();
        $data = compact('items', 'restaurants');
        return view('layouts.pages.restaurantitem.add')->with($data);
    }

    function store(Request $request)
    {

        $validated = $request->validate([
            'restaurant_id' => 'required',
            'item_id' => 'required',

        ]);

        try {
            $rest = new ResturantItem();
            $rest->restaurant_id = $request->restaurant_id;
            $rest->item_id = $request->item_id;
            // dd($rest->item_id);
            $rest->save();

            return redirect()->back()->with('success', `Information added successfully!`);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error: ');
        }
    }

    function delete($id)
    {
        // dd($id);
        $restaurantitem = ResturantItem::find($id);
        if (!$restaurantitem) {
            return redirect()->back()->with('error', 'Restaurant not found.');
        }

        $restaurantitem->delete();
        return redirect()->back();
    }
}
