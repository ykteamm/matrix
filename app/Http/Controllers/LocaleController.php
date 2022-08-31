<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    // public function setLang($locale){
    //     App::setLocale($locale);
    //     Session::put("locale",$locale);
    //     return redirect()->back();
    // }

    // public function lang_change(Request $request){
    //     $lang = $request->get('lang');
    //     // $id = Auth::user()->id;
    //     // $changing = DB::update("update users set language='$lang' where id=$id");
    //     session(['locale' => $lang]);
    //     return redirect()->back();
    //     // return $request;
    // }
    public function __construct()
    {
        // $this->middleware('auth'); 
    }
    public function switch(Request $request, $locale)
    {
        // App::setLocale($locale);

        session(['APP_LOCALE' => $locale]);
        return redirect()->back();
    }
}
