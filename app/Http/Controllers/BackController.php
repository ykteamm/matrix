<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    public function back()
    {
        // return Schema::hasTable('patient');
        return view('patient.back');
    }

    public function search(Request $request)
    {
        // return Schema::hasTable('patient');
        $pin_pas = $request->pin_pas;
        $patient = DB::table('patients')->where('pinfl',$pin_pas)->orWhere('passport',$pin_pas)->get();
        // return view('patient.back',compact('patient'));
        return $patient;
    }
}
