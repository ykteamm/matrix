<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        return 123;
    }

    public function adminLogin()
    {
        view('admin.login');
    }
}
