<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Position;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        // $request->validate([
        //     'login' => 'required',
        //     'password' => 'required|min:4',
        // ]);
        // $user = DB::table('tg_user')->where('username',$request->login)->first();
        // if(isset($user->pr))
        // {
        //     if($user->pr == $request->password)
        //     {
        //     Session::put('user', $user);
        //     Session::put('time', time());
        //     return redirect()->route('blackjack');

        //     }
        //     else{
        //         return redirect()->route('blackjack');
        //     }

        // }
            Session::put('user', 21);
        return redirect()->route('blackjack');
        

    }
}
