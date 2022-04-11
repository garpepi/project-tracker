<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthClientAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (session()->has('token')) {
            // dd(session()->get('token')['user']['role']);
            return $next($request);
        } else {
            // Alert::error('Please Login', 'Access denied');
            return redirect()->route('login');
        }
    }
}
