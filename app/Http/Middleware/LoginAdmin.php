<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginAdmin
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
        if(Session::has('admin_time'))
        {
            if((time() - Session::get('admin_time')) > 3600)
            {
                Session::remove('admin_user');
            }
        }
        
        if (Session::has('admin_user')) {
            return $next($request);
        }else{
            return redirect()->route('admin-index');
        }
    }
}
