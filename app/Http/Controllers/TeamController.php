<?php

namespace App\Http\Controllers;

use App\Services\ElchiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\TeamBattle;
use App\Models\Region;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{

    public function index($time)
    {
        $regions = Region::all();
        $teams = Region::with('team')->get();
        $users = User::whereNotIn('level',[1])->get();
        $members = Member::with('user')->get();
        $sum=[];
        foreach ($members as $key => $value) {
                $sums = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                    ->whereDate('tg_productssold.created_at','>=','2022-10-01')
                    ->whereDate('tg_productssold.created_at','<=','2022-10-31')
                    ->where('tg_user.id','=',$value->user_id)
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->value('allprice');
                if(isset($sums))
                {
                    $sum[$value->team_id][$value->user_id]=$sums;
                }else{
                    $sum[$value->team_id][$value->user_id]=0;
                }
        }
        // return $members;
        return view('team.index',compact('regions','teams','users','members','sum'));

    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
    public function teamBattle()
    {
        $teams = Team::all();
        $battles = TeamBattle::all();
        $team_battle=[];
        foreach($battles as $batle)
        {
            $team1 = Team::where('id',$batle->team1_id)->value('name');
            $team2 = Team::where('id',$batle->team2_id)->value('name');
            if(date('Y-m-d',strtotime($batle->begin )) < date('Y-m-d',strtotime(date_now() )) && date('Y-m-d',strtotime($batle->end )) < date('Y-m-d',strtotime(date_now() )))
            {
                $ended = 1;
            }else{
                $ended = 0;

            }
            $team_battle[] = array('id' => $batle->id,'team1' => $team1, 'team2' => $team2,'ended' => $ended,'begin' => $batle->begin, 'end' => $batle->end);

        }
        return view('team.battle',compact('team_battle','teams'));

    }
    public function teamBattleView($id)
    {
        $battles = TeamBattle::where('id',$id)->get();
        $team1=[];
        $users=[];
        foreach($battles as $batle)
        {
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->whereDate('tg_productssold.created_at','<=',$batle->end)
                ->where('tg_members.team_id',$batle->team1_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');
            if(count($teams22) == 0)
            {
                $team1[$batle->team1_id] = 0;
            }else{
                foreach($teams22 as $key => $team)
                {
                    $team1[$key] = $team;
                }

            }
            
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->whereDate('tg_productssold.created_at','<=',$batle->end)
                ->where('tg_members.team_id',$batle->team2_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');

                if(count($teams22) == 0)
                {
                    $team1[$batle->team2_id] = 0;
                }else{
                    foreach($teams22 as $key => $team)
                    {
                        $team1[$key] = $team;
                    }
    
                }
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->whereDate('tg_productssold.created_at','<=',$batle->end)
                ->where('tg_members.team_id',$batle->team1_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->whereDate('tg_productssold.created_at','<=',$batle->end)
                ->where('tg_members.team_id',$batle->team2_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;

        }

        //  return $team1;
        $teams = Team::all();

        return view('team.battle-view',compact('team1','teams','battles','users'));
    }
    public function teamBattleDate(Request $request,$id)
    {
        $battles = TeamBattle::where('id',$id)->get();
        $team1=[];
        $users=[];
        foreach($battles as $batle)
        {
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$request->begin)
                ->whereDate('tg_productssold.created_at','<=',$request->end)
                ->where('tg_members.team_id',$batle->team1_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');
            if(count($teams22) == 0)
            {
                $team1[$batle->team1_id] = 0;
            }else{
                foreach($teams22 as $key => $team)
                {
                    $team1[$key] = $team;
                }

            }
            
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$request->begin)
                ->whereDate('tg_productssold.created_at','<=',$request->end)
                ->where('tg_members.team_id',$batle->team2_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');

                if(count($teams22) == 0)
                {
                    $team1[$batle->team2_id] = 0;
                }else{
                    foreach($teams22 as $key => $team)
                    {
                        $team1[$key] = $team;
                    }
    
                }
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$request->begin)
                ->whereDate('tg_productssold.created_at','<=',$request->end)
                ->where('tg_members.team_id',$batle->team1_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$request->begin)
                ->whereDate('tg_productssold.created_at','<=',$request->end)
                ->where('tg_members.team_id',$batle->team2_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;

        }

        //  return $team1;
        $teams = Team::all();

        return view('team.battle-view',compact('team1','teams','battles','users','request'));
    }
    public function teamBattle2()
    {
        $teams = Team::all();
        // $regions = Region::all();
        // $teams = Region::with('team')->get();
        // $users = User::whereNotIn('level',[1])->get();
        // $members = Member::with('user')->get();

        $battles = TeamBattle::all();
        $team1=[];
        $users=[];
        foreach($battles as $batle)
        {
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->where('tg_members.team_id',$batle->team1_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');
            foreach($teams22 as $key => $team)
            {
                $team1[$key] = $team;
            }
            $teams22=DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.team_id')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->where('tg_members.team_id',$batle->team2_id)
                ->leftjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->groupBy('tg_members.team_id')->pluck('allprice','tg_members.team_id');
            foreach($teams22 as $key => $team)
            {
                $team1[$key] = $team;
            }
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->where('tg_members.team_id',$batle->team1_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;
            $members = DB::table('tg_members')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_members.id, tg_members.team_id,tg_user.first_name as f_name,tg_user.last_name as l_name,tg_user.level as level')
                ->whereDate('tg_productssold.created_at','>=',$batle->begin)
                ->where('tg_members.team_id',$batle->team2_id)
                ->rightjoin('tg_productssold','tg_productssold.user_id','tg_members.user_id')
                ->join('tg_user','tg_user.id','tg_members.user_id')
                ->groupBy('tg_members.id','tg_members.team_id','tg_user.first_name','tg_user.last_name','tg_user.level')->get();

            $users[]=$members;

        }

        // return $users;
        return view('team.battle',compact('team1','teams','battles','users'));
    }

    public function teamBattleStore(Request $request)
    {
        $inputs = $request->all();
        // unset($inputs['_token']);
        $new_battle = new TeamBattle($inputs);
        $new_battle->save();
        if($new_battle->id)
        {
            return redirect()->back();
        }
    }
}
