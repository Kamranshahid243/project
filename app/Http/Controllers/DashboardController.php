<?php

namespace App\Http\Controllers;

use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role->role == 'Admin') {
            $shop = Shop::where('shop_id',Auth::user()->shop_id)->first();
            Session::put('shop' , $shop);
        }
        return view('dashboard.dashboard');
    }
}
