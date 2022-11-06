<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamWarsController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('team.wars',compact('teams'));
    }

    public function store(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);

        dd($request->all());
    }
}
