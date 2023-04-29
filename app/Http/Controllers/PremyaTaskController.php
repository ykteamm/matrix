<?php

namespace App\Http\Controllers;

use App\Models\PremyaTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PremyaTaskController extends Controller
{
    public function index() 
    {
        $premyaTasks = DB::table('premya_tasks as t')
            ->selectRaw('u.id, u.first_name, u.last_name, t.prodaja, p.task, p.premya')
            ->join('tg_user as u', 'u.id', 't.user_id')
            ->join('premyas as p', 'p.id', 't.premya_id')
            ->get();
        return view('premya.index', compact('premyaTasks'));
    }
}
