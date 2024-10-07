<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::paginate(4);
        $allRestaurants = Restaurant::all();  
    
        return view('layouts.pages.restaurant.index', compact('restaurants', 'allRestaurants'));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $restaurantFilter = $request->input('restaurant_id');
    
        $restaurants = Restaurant::query();
    
        if ($query) {
            $restaurants->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhere('address', 'LIKE', "%{$query}%");
        }
    
        if ($restaurantFilter) {
            $restaurants->where('id', $restaurantFilter);
        }
    
        $restaurants = $restaurants->paginate(4);
    
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.restaurant.restaurant-table', compact('restaurants'))->render(),
                'pagination' => (string) $restaurants->appends(['query' => $query, 'restaurant_id' => $restaurantFilter])->links(),
            ]);
        }
    
        return view('layouts.pages.restaurant.index', compact('restaurants'));
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
