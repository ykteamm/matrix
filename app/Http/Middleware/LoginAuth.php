<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginAuth
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

        if(Session::has('time'))
        {
            if((time() - Session::get('time')) > 7200)
        {
            Session::remove('user');
        }
        }
        
        if (Session::has('user')) {
            return $next($request);
        }else{
            // return route('login');
            return redirect()->route('sign-in');
            // return view('admin.index');

        }
    }
}
