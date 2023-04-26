<?php

namespace App\Http\Controllers;

use App\Models\ProductSold;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DublicatController extends Controller
{
    public function index()
    {
        $users_id = ProductSold::distinct('user_id')->pluck('user_id')->toArray();
        $users = DB::table('tg_user')->whereNotIn('id',$users_id)->get('id');

        return $users_id;

        return view('dublicat.index',[
            'users' => $users
        ]);
    }
}
