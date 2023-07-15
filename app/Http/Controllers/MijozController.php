<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MijozController extends Controller
{
    public function banner()
    {

        $users = DB::table('tg_productssold')
        ->selectRaw('SUM(tg_productssold.price_product * tg_productssold.number) as allprice, tg_productssold.user_id as id, tg_user.first_name AS f, tg_user.last_name AS l')
        ->leftJoin('tg_user', 'tg_user.id', 'tg_productssold.user_id')
        ->whereDate('tg_productssold.created_at', '>=', '2023-07-10')
        ->whereDate('tg_productssold.created_at', '<=', '2023-07-15')
        ->groupBy('tg_productssold.user_id', 'f', 'l')
        ->orderBy('allprice', 'DESC')
        ->get();

        return view('mijoz.index',compact('users'));
    }
}
