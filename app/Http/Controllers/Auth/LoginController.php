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
use App\Models\ElchiLevel;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

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

        $request = new AuthService($request);

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
        // if($userd->admin == 'false')
        // {
        //     $elchi_level = ElchiLevel::where('user_id',$userd->rol_id)->get();
        //     if(count($elchi_level) == 0)
        //     {
        //         $elchi_level = new ElchiLevel([
        //             'user_id' => $userd->rol_id,
        //             'level' => 1,
        //         ]);
        //         $elchi_level->save();
        //     }
        // }

            $per = DB::table('tg_positions')->where('id',$userd->rol_id)->first();
            // return $per->position_json;
            $pcode = json_decode($per->position_json,TRUE);
            $admin_code = json_decode($userd->position,TRUE);
            Session::put('per', $pcode);
            Session::put('per_admin', $admin_code);
            Session::put('user', $userd);
            Session::put('time', time());

            $id = Session::get('user')->id;
            $cap = Member::where('user_id',Session::get('user')->id)->first();
            $cap = DB::table('tg_user')->where('id',Session::get('user')->id)->value('level');
            $rm = DB::table('tg_user')->where('id',Session::get('user')->id)->value('rm');
            // $rm = DB::table('tg_user')->where('id',$id)->value('rm');
            Session::put('cap', $cap);
            Session::put('rm', $rm);

            return redirect()->route('blackjack');

        }
        else{
        return redirect()->back();

        }
        //     Session::put('user', 21);
        // return redirect()->route('blackjack');


    }

    public function adminLogin(Request $request)
    {
        $users = User::all();

        foreach($users as $user)
        {
            if (Hash::check($request->password, $user->admin_password)) {
                $us = $user;
            }

        }

        if(!isset($us))
        {
            return redirect()->back();
        }


        $pcode = json_decode($us->position,TRUE);
        Session::put('admin_pos', $pcode);
        Session::put('admin_user', $us);
        Session::put('admin_time', time());

        return redirect()->route('admin');

    }
}
