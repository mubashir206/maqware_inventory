<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantuserController;
use App\Http\Controllers\ResturantItemController;
use App\Http\Controllers\UsageHistoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//route for the restaurnat
Route::get('/restaurnat', [RestaurantController::class, 'index'])->name('restaurant')->middleware('auth');
Route::get('/restaurnat/add', [RestaurantController::class, 'add'])->name('restaurant.add');
Route::post('/restaurnat/store', [RestaurantController::class, 'store'])->name('restaurant.store')->middleware('auth');
Route::get('/restaurnat/delete/{id}', [RestaurantController::class, 'delete'])->name('restaurant.delete')->middleware('auth');
//route  for restaurant user
Route::get('/restaurnat/user/{id}', [RestaurantuserController::class, 'index'])->name('restaurant.user')->middleware('auth');
Route::get('restaurant/user/addPage/{id}', [RestaurantuserController::class, 'addPage'])->name('restaurant.user.addPage')->middleware('auth');
Route::post('/restaurnat/user/store', [RestaurantuserController::class, 'store'])->name('restaurant.user.store')->middleware('auth');
Route::get('/restaurnat/user/delete/{id}', [RestaurantuserController::class, 'delete'])->name('restaurant.user.delete')->middleware('auth');
// route for the items 
Route::get('item', [ItemController::class, 'index'])->name('item')->middleware('auth');
Route::get('item/addPage', [ItemController::class, 'addPage'])->name('item.addPage')->middleware('auth');
Route::post('item/store', [ItemController::class, 'store'])->name('item.store')->middleware('auth');
Route::post('item/update/{id}', [ItemController::class, 'update'])->name('item.update')->middleware('auth');
Route::get('item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit')->middleware('auth');
Route::get('item/history', [ItemController::class, 'history'])->name('item.history')->middleware('auth');
Route::get('item/delete/{id}', [ItemController::class, 'delete'])->name('item.delete')->middleware('auth');

// route for the restaurant items 
Route::get('restaurnat/item/{id}', [ResturantItemController::class, 'index'])->name('restaurant.item')->middleware('auth');
Route::get('restaurnat/item/addPage/{id}', [ResturantItemController::class, 'addPage'])->name('restaurant.item.addPage')->middleware('auth');
Route::post('restaurnat/item/store', [ResturantItemController::class, 'store'])->name('restaurant.item.store')->middleware('auth');
Route::get('restaurnat/item/delete/{id}', [ResturantItemController::class, 'delete'])->name('restaurant.item.delete')->middleware('auth');

//usage histories 
Route::get('item/reduce', [UsageHistoryController::class, 'index'])->name('item.reduce')->middleware('auth');

