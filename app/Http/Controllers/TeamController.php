<?php

namespace App\Http\Controllers;

use App\Services\ElchiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\Region;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($time)
    {
//        return Session::get('user')->id;
        $service=new ElchiService();
        $time=$service->day($time);
        $date_begin = $time->date_begin;
        $date_end = $time->date_end;
        $dateText=$time->dateText;
        $regions = Region::all();
        $teams = Region::with('team')->get();
        $users = User::whereNotIn('level',[1])->get();
        $members = Member::with('user')->get();
        $members2 = DB::table('tg_members')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
            ->join('tg_user','tg_user.id','tg_members.user_id')
            ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();


        $count=$members2->count();
//
        $team1=DB::table('tg_members')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
            ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');
//        dd($team1);
        return view('team.index',compact('count','team1','members2','dateText','regions','teams','users','members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $new = new Team($inputs);
        $new->save();
        if($new->id)
        {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
