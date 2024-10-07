<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantuserController extends Controller
{
    public function index(Request $request, $id)
    {
        $query = $request->input('query');
        $selectedRestaurant = $request->input('restaurant'); 
    
        $restaurants = Restaurant::all(); 
    
        $restUser = RestaurantUser::where('restaurant_id', '=', $id)
            ->when($selectedRestaurant, function ($q) use ($selectedRestaurant) {
                $q->where('restaurant_id', $selectedRestaurant); 
            })
            ->when($query, function ($q) use ($query) {
                $q->whereHas('user', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('restaurant', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(4);
    
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('layouts.pages.restaurantuser.table', compact('restUser'))->render(),
                'pagination' => (string) $restUser->appends(['query' => $query, 'restaurant' => $selectedRestaurant])->links(),
            ]);
        }
    
        return view('layouts.pages.restaurantuser.index', compact('restUser', 'id', 'restaurants', 'selectedRestaurant'));
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
