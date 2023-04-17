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
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }
        $regions = Region::all();
        $teams = Region::with('team')->get();
        $users = User::whereNotIn('level',[1])->get();
        $members = Member::with('user')->get();
        $sum=[];
        foreach ($members as $key => $value) {
                $sums = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                    ->whereDate('tg_productssold.created_at','>=',$date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$date_end)
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
        return view('team.index',compact('dateText','regions','teams','users','members','sum'));

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
        unset($inputs['_token']);
        // return $inputs;
            $arrayDate = [];
            $Variable1 = strtotime($inputs['begin']);
            $Variable2 = strtotime($inputs['end']);
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
            {                        
                $Store = date('Y-m'.'-01', $currentDate);
                $Store2 = date('Y-m-d', $currentDate);
                $arrayDate[$Store] = $Store2;
                
            }
            // dd($arrayDate);
        $round = 0;
        $battle = [];
        
        foreach ($arrayDate as $startOfMonth => $endOfMonth) {
            $round += 1;
            $battle[$startOfMonth] = [];
            $battle[$startOfMonth][$round] = [];
            $dayCount = (int)date("d", strtotime($endOfMonth));
            $startOfMonthWeekDay = (int)date("w", strtotime($startOfMonth));
            $is = false;
            for ($i = 0; $i < $dayCount; $i++) {
                $currentWeekDay = (int)date("w", strtotime("+$i day", strtotime($startOfMonth)));
                if($currentWeekDay != 0)
                {
                    if($i == 0 && $startOfMonthWeekDay == 4) {
                        $battle[$startOfMonth][$round][] = date("Y-m-d", strtotime("+$i day", strtotime($startOfMonth)));
                        continue;
                    }
                    if($i == 1 && $startOfMonthWeekDay == 4) {
                        $battle[$startOfMonth][$round][] = date("Y-m-d", strtotime("+$i day", strtotime($startOfMonth)));
                        continue;
                    }
                    if($i == 0 && $startOfMonthWeekDay == 5) {
                        $battle[$startOfMonth][$round][] = date("Y-m-d", strtotime("+$i day", strtotime($startOfMonth)));
                        continue;
                    }
                    if($i == ($dayCount - 1) && $currentWeekDay == 5) {
                        $battle[$startOfMonth][$round][] = date("Y-m-d", strtotime("+$i day", strtotime($startOfMonth)));
                        continue;       
                    }
                    if($currentWeekDay == 5) {
                        $round += 1;
                        $battle[$startOfMonth][$round] = [];
                    }
                    $battle[$startOfMonth][$round][] = date("Y-m-d", strtotime("+$i day", strtotime($startOfMonth)));
                }
            }
        }
        // dd($battle);
        foreach ($battle as $month => $rounds) {
           foreach ($rounds as $round => $days) {
                $new_battle = new TeamBattle([
                    'team1_id' => $inputs['team1_id'],
                    'team2_id' => $inputs['team2_id'],
                    'month' => $month,
                    'round' => $round,
                    'start_day' => $days[0],
                    'end_day' => $days[count($days)-1],
                ]);
                $new_battle->save();
           }
        }
        // return $d['2023-02-01'];
        // $new_battle = new TeamBattle([
        //     'team1_id' => $inputs['team1_id'],
        //     'team2_id' => $inputs['team2_id'],
        //     'month' => $inputs['team2_id'],
        // ]);
        // $new_battle->save();
        // if($new_battle->id)
        // {
            return redirect()->back();
        // }
    }
}
