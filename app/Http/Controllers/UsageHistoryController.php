<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use App\Models\UsageHistory;
use Illuminate\Http\Request;

class UsageHistoryController extends Controller
{

    function index(){
        $usageHistorys = UsageHistory::all();
        $data = compact('usageHistorys');
        return view('layouts.pages.usageHistory.index')->with($data);
    }
    
}
