<?php

namespace App\Http\Controllers;

use App\PageAction;
use Illuminate\Http\Request;

class PageActionController extends Controller
{
    public function index(Request $request)
    {
        if($request->wantsJson())
            return PageAction::with('page', 'roles')->get();
        return "";
    }
}
