<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    function index(){
    return view('customAuth.register');
    }
}
