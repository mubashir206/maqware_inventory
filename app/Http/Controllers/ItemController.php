<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\ItemType;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    function index()
    {
        $items = Item::all();
        $data = compact('items');
        return view('layouts.pages.items.index')->with($data);
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
            // dd($item->user_id );

            $item->save();

            // item histories function 
            
            $itemHistory = new ItemHistory();
            $itemHistory->name = $request->name;
            $itemHistory->description = $request->description;
            $itemHistory->quantity = $request->quantity;
            $itemHistory->item_type_id = $request->item_type_id;
            $itemHistory->restaurant_id = $request->restaurant_id;
            $itemHistory->user_id = Auth::id();
            $itemHistory->save();

            return redirect()->back()->with('success', 'The information has been inserted successfully !');
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
    
    function update(Request $request, $id){
        
        $validation = $request->all([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required',
            'item_type_id' => 'required',
            'restaurant_id' => 'required',
        ]);

        try {
            $item = Item::find($id);
            $item->name = $request->name;
            $item->description = $request->description;
            $item->quantity = $request->quantity;
            $item->item_type_id = $request->item_type_id;
            $item->restaurant_id = $request->restaurant_id;
            $item->user_id = Auth::id();
            // dd($item);
            $item->save();

             // item histories function 
            
             $itemHistory = new ItemHistory();
             $itemHistory->name = $request->name;
             $itemHistory->description = $request->description;
             $itemHistory->quantity = $request->quantity;
             $itemHistory->item_type_id = $request->item_type_id;
             $itemHistory->restaurant_id = $request->restaurant_id;
             $itemHistory->user_id = Auth::id();
             $itemHistory->save();

            return redirect()->back()->with('success', 'The information has been updated successfully !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error found');
        }
    }

    function history()
    {
        $itemshistory = ItemHistory::all();
        $data = compact('itemshistory');
        return view('layouts.pages.items.history')->with($data);
    }

}
