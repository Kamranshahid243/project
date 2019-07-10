<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        // rbac
        $admin = \Auth::user();
        $role = $admin->role;
        /* @var $role UserRole */
        if (!$role->canAccess($request->route()))
            abort(401, "Sorry, you are not authorized for this action.");

        return $next($request);
    }
}
