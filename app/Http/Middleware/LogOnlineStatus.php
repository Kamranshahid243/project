<?php

namespace App\Http\Middleware;

use App\Helpers\UserOnlineStatusHandler;
use Closure;

class LogOnlineStatus
{
    protected static $expiresAt = 600;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( $admin = \Auth::user() ) {
            $handler = app('osh');
            /* @var $handler UserOnlineStatusHandler */
            $handler->log();
        }

        return $next($request);
    }
}
