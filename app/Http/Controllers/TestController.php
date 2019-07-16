<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Shop::findRequested();
        }
        return view('test.test');
    }
}
