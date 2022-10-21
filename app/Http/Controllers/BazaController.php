<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BazaController extends Controller
{
    public function database()
    {
        return view('database.blade.php');
    }
}
