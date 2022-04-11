<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MenuSpecificRoleAccess
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
            }elseif (session()->get('token')['user']['role'] == 'User') {
                return $next($request);
            }elseif (session()->get('token')['user']['role'] == 'Owner') {
                return $next($request);
            }elseif (session()->get('token')['user']['role'] == 'Manager') {
                return $next($request);
            }
            else{
                Alert::error('You Not Have Access', 'Access denied');
                return back();
            }
        }   else {
            Alert::error('Please Login', 'Access denied');
            return redirect()->route('login');
        }
    }
}
