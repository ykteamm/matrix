<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// namespace App\Http\Middleware;

// use Closure;
// use App;
use Config;
// use Session;

class SetLanguage
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
        // if(Session::get("locale","en") != null){
        //     App::setLocale(Session::get("locale"));
        // }
        // else{
        //     Session::put("locale","en");
        //     App::setLocale(Session::get("locale"));
        // }

        // return $next($request);
    //     $raw_locale = $request->session()->get('locale');
    //  if (in_array($raw_locale, Config::get('app.locales'))) {
    //    $locale = $raw_locale;
    //  }
    //  else $locale = Config::get('app.locale');
    //    App::setLocale($locale);
    //    return $next($request);
        $locales = ['en','uz','ru'];
        $locale = session('APP_LOCALE');
        $locale = in_array($locale,$locales) ? $locale : config('app.locale');
        app()->setlocale($locale);
        return $next($request);
    }
}
