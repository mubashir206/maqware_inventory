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
    function index($id)
    {
        $items = Item::where('restaurant_id', '=', $id)->get();
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
