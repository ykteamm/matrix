<?php

namespace App\Http\Controllers;

use App\Items\SundayItems;
use App\Models\TurnirGroup;
use App\Models\TurnirMember;
use App\Models\TurnirPoint;
use App\Models\TurnirStanding;
use App\Models\TurnirTeam;
use App\Models\TurnirTeamGroup;
use App\Models\User;
use Illuminate\Http\Request;

class TurnirController extends Controller
{
    public function team()
    {
        $teams = TurnirTeam::with(['turnir_member' => function ($q) {
            $q->whereDate('month', date('Y-m') . '-01');
            $q->orderBy('tour');
        }, 'turnir_member.user' => function ($u) {
            $u->select('id', 'first_name', 'last_name');
        }])
            ->get();
        // with('turnir_member','turnir_member.user')
        // return $teams;
        $users = User::whereIn('status', [0, 1])->orderBy('first_name', 'ASC')->get();

        // $members = TurnirMember::with(['team' => function($team){
        //     $team->select('id','name');
        // },'user' => function($user){
        //     $user->select('id','first_name','last_name');
        // }])
        // ->whereDate('month',date('Y-m').'-01')->orderBy('tour','ASC')->orderBy('team_id','ASC')->get();
        // return $members;

        return view('turnir.team', [
            'teams' => $teams,
            'users' => $users
        ]);
    }

    public function group()
    {
        $groups = TurnirGroup::with('team_group', 'team_group.group')->get();

        $teams = TurnirTeam::all();


        // return $teams;
        return view('turnir.group', [
            'teams' => $teams,
            'groups' => $groups
        ]);
    }

    public function memberStore(Request $request)
    {
        for ($i = 1; $i <= 3; $i++) {
            $member = new TurnirMember;
            $member->team_id = $request->team_id;
            $member->user_id = $request->user_id;
            $member->month = $request->month;
            $member->tour = $i;
            $member->save();
        }

        return redirect()->back();
    }

    public function teamGroupStore(Request $request)
    {
        $member = new TurnirTeamGroup();
        $member->team_id = $request->team_id;
        $member->group_id = $request->group_id;
        $member->month = $request->month;
        $member->save();

        return redirect()->back();
    }

    public function groupState()
    {
        return view('turnir.standing');
    }

    public function groupStateStore(Request $request)
    {
        $month = $request->month;

        $groups = TurnirGroup::with(['team_group' => function ($team) {
            $team->orderBy('id', 'ASC');
        }])->get();

        $teams = [];

        foreach ($groups as $key => $group) {
            if (count($group->team_group) > 0) {
                $team1id = $group->team_group[0]->team_id;
                $team2id = $group->team_group[1]->team_id;
                $team3id = $group->team_group[2]->team_id;
                $team4id = $group->team_group[3]->team_id;
                for ($i = 1; $i <= 3; $i++) {

                    if ($i == 1) {
                        $begin = $request->begin_date;
                        $start_index_day = date('Y-m-d', (strtotime('+1 day', strtotime($begin))));
                        $end_index_day = date('Y-m-d', (strtotime('+' . $request->day . ' day', strtotime($begin))));
                        $no_sundays = $this->deleteSunday($start_index_day, $end_index_day);
                        $start_day = $no_sundays->start_day;
                        $end_day = $no_sundays->end_day;

                        $teams[] = array(
                            'team1_id' => $team1id,
                            'team2_id' => $team2id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );

                        $teams[] = array(
                            'team1_id' => $team3id,
                            'team2_id' => $team4id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );

                        $begin = $end_day;
                    } elseif ($i == 2) {
                        $start_index_day = date('Y-m-d', (strtotime('+1 day', strtotime($begin))));
                        $end_index_day = date('Y-m-d', (strtotime('+' . $request->day . ' day', strtotime($begin))));
                        $no_sundays = $this->deleteSunday($start_index_day, $end_index_day);
                        $start_day = $no_sundays->start_day;
                        $end_day = $no_sundays->end_day;

                        $teams[] = array(
                            'team1_id' => $team1id,
                            'team2_id' => $team3id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );

                        $teams[] = array(
                            'team1_id' => $team2id,
                            'team2_id' => $team4id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );

                        $begin = $end_day;
                    } else {
                        $start_index_day = date('Y-m-d', (strtotime('+1 day', strtotime($begin))));
                        $end_index_day = date('Y-m-d', (strtotime('+' . $request->day . ' day', strtotime($begin))));
                        $no_sundays = $this->deleteSunday($start_index_day, $end_index_day);
                        $start_day = $no_sundays->start_day;
                        $end_day = $no_sundays->end_day;

                        $teams[] = array(
                            'team1_id' => $team1id,
                            'team2_id' => $team4id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );

                        $teams[] = array(
                            'team1_id' => $team2id,
                            'team2_id' => $team3id,
                            'group_id' => $group->id,
                            'date_begin' => $start_day,
                            'date_end' => $end_day,
                            'month' => $month,
                            'tour' => $i,
                        );
                    }
                }
            }
        }

        foreach ($teams as $key => $team) {

            $this->battleSave($team);
        }

        return redirect()->back();
    }

    public function battleSave($team)
    {
        $new = TurnirStanding::create([
            'group_id' => $team['group_id'],
            'team1_id' => $team['team1_id'],
            'team2_id' => $team['team2_id'],
            'tour' => $team['tour'],
            'date_begin' => $team['date_begin'],
            'date_end' => $team['date_end'],
            'month' => $team['month'],
        ]);
        TurnirPoint::create([
            'point' => 0,
            'team_id' => $team['team1_id'],
            'tour' => $team['tour'],
            'month' => $team['month']
        ]);
        TurnirPoint::create([
            'point' => 0,
            'team_id' => $team['team2_id'],
            'tour' => $team['tour'],
            'month' => $team['month']
        ]);
    }

    public function deleteSunday($start_index_day, $end_index_day)
    {
        $arrayDate = array();
        $Variable1 = strtotime($start_index_day);
        $Variable2 = strtotime($end_index_day);
        $sum = 0;
        for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
            $Store = date('w', $currentDate);
            if ($Store == 0) {
                $sum += 1;
            } else {
                $arrayDate[] = date('Y-m-d', $currentDate);
            }
        }
        if ($sum > 0) {
            for ($i = 1; $i <= $sum; $i++) {
                $ends = date('w', (strtotime('+1 day', strtotime(end($arrayDate)))));
                if ($ends == 0) {
                    $endsw = date('Y-m-d', (strtotime('+2 day', strtotime(end($arrayDate)))));
                } else {
                    $endsw = date('Y-m-d', (strtotime('+1 day', strtotime(end($arrayDate)))));
                }
                $arrayDate[] = $endsw;
            }
        }
        $start_day = $arrayDate[0];
        $end_day = end($arrayDate);

        $item = new SundayItems();
        $item->start_day = $start_day;
        $item->end_day = $end_day;
        return $item;
    }
}
