<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantuserController extends Controller
{
    function index($id)
    {
        // dd($filterRest);
        $restUser = RestaurantUser::where('restaurant_id', '=', $id)->get();
        $data = compact('restUser', 'id');
        return view('layouts.pages.restaurantuser.index')->with($data);
    }

    function addPage($id)
    {
        $restaurants = Restaurant::where('id', '=', $id)->get();
        // dd($restaurants);
        $users = User::all();
        $data = compact('restaurants', 'users');
        return view('layouts.pages.restaurantuser.add')->with($data);
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required',
            'user_id' => 'required',
            'is_manager' => 'required',
        ]);
        
        try {
            $rest = new RestaurantUser();
            $rest->restaurant_id = $request->restaurant_id;
            $rest->user_id = $request->user_id;
            $rest->is_manager = $request->is_manager;
            // dd($rest);
            $rest->save();

            return redirect()->back()->with('success', `Restaurant's user added successfully!`);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error: ');
        }
    }
    
    function delete($id)
    {
        // dd($id);
        $restaurant = RestaurantUser::find($id);
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurant user not found.');
        }
        $restaurant->delete();
        return redirect()->back();
    }
}
