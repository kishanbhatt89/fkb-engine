<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientEmailVerified
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
        if (auth('client')->user()->email_verified_at == null) {

            auth('client')->logout();

            return response()->json(['msg' => 'You need to confirm your account. We have sent you an activation code, please check your email.']);            

        }
   
        return $next($request);
    }
}
