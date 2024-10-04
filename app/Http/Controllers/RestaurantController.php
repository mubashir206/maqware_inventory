<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class RestaurantController extends Controller
{
    function index(){
        $restaurants= Restaurant::paginate(10);
        $data = compact('restaurants');
        return view('layouts.pages.restaurant.index')->with($data);
    }

    function add(){
        return view('layouts.pages.restaurant.add');
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email|unique:restaurants,email',
            'phone' => 'required',
        ]);
    
        try {
            $restaurant = new Restaurant();
            $restaurant->name = $request->name;
            $restaurant->address = $request->address;
            $restaurant->email = $request->email;
            $restaurant->phone = $request->phone;
            // dd($restaurant);
            $restaurant->save();
    
            return redirect()->back()->with('success', 'Restaurant added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error foun  ');
        }
    }
    
    function delete($id){
        // dd($id);
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurant not found.');
        }
        $restaurant->delete();
        return redirect()->back();
    }

}
