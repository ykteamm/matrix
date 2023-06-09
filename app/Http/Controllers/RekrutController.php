<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekrutController extends Controller
{
    public function addUser()
    {
        $regions = Region::all();
        $districts = DB::table('tg_district')->get();

        $rms = User::where('rm',1)->get();

        return view('rekrut.add',[
            'regions' => $regions,
            'districts' => $districts,
            'rms' => $rms,
        ]);

    }
    public function saveUser(Request $request)
    {
        return $request;
    }
}
