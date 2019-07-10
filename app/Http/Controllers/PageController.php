<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if($request->wantsJson())
            return Page::with('actions')->get();
        return "";
    }
}
