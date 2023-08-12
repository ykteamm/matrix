<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    

    

    public function login(Request $request)
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


        return $this->authenticated($request, $user);
    }


}
