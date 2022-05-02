<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (session()->has('token')) {
            if (session()->get('token')['user']['role'] == 'Admin') {
                return $next($request);
            }else{
                Alert::error('You Not Have Access', 'Access denied');
                return back();
            }
        }   else {
            Alert::error('Please Login', 'Access denied');
            return redirect()->route('login');
        }

    }
}
