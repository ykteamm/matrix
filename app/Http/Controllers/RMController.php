<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RMController extends Controller
{
    public function index()
    {
        return view('rm.index');
    }
    public function region()
    {
        return view('rm.region');
    }
}
