<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function solds10()
    {
        $solds = DB::table('tg_productssold')->limit('10')->orderby('id','DESC')->get();
        return $solds;
    }
}
