<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait AuthenticatesUsers
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers {
        \Illuminate\Foundation\Auth\AuthenticatesUsers::logout as parentLogout;
    }

    public function logout(Request $request)
    {
        app('osh')->remove();
        return $this->parentLogout($request);
    }

}
