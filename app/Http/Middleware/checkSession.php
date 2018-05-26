<?php

namespace App\Http\Middleware;

use Closure;

class checkSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((session("isLoggedin")) && session("isLoggedin")==1) {
            return $next($request);
        } else {
            exit(
                json_encode(
                    array(
                    'status' => 0,
                    'message' => 'You are logged out, Login again.'
                    )
                )
            );
        }
    }
}
