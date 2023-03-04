<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function solds10()
    {
        $solds = DB::table('tg_productssold')->limit('10')->orderby('id','DESC')->first();
        $day = date('Y-m-d',strtotime($solds->created_at));
        $hour = date('H:i',strtotime($solds->created_at));
        return $solds->created_at.' T '.$day.' T '.$hour;
    }
}
