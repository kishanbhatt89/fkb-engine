<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('client')->user()->is_active == 0) {            

            return response()->json(['msg' => 'Your account is blocked please contact administrator']);            

        }
   
        return $next($request);
    }
}
