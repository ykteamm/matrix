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
use App\Models\Member;


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
        // $user = DB::table('tg_user')->where('admin',true)->get();
        // return $user;
        $request->validate([
            'login' => 'required',
            'password' => 'required|min:4',
        ]);
        $user = DB::table('tg_user')->where('username',$request->login)
        ->where('pr',$request->password)
        // ->where('admin',true)
        ->exists();

        if($user)
        {
            $userd = DB::table('tg_user')->where('username',$request->login)
        ->where('pr',$request->password)
        // ->where('admin',true)
        ->first();
            $per = DB::table('tg_positions')->where('id',$userd->rol_id)->first();
            // return $per->position_json;
            $pcode = json_decode($per->position_json,TRUE);
            Session::put('per', $pcode);
            Session::put('user', $userd);
            Session::put('time', time());

            $id = Session::get('user')->id;
            $cap = Member::where('user_id',Session::get('user')->id)->first();
            // $rm = DB::table('tg_user')->where('id',$id)->value('rm');
            Session::put('cap', $cap);

            return redirect()->route('blackjack');

        }
        else{
        return redirect()->back();

        }
        //     Session::put('user', 21);
        // return redirect()->route('blackjack');
        

    }
}
