<?php

namespace App\Http\Controllers;

use App\Items\SundayItems;
use App\Models\TurnirGroup;
use App\Models\TurnirMember;
use App\Models\TurnirPoint;
use App\Models\TurnirStanding;
use App\Models\TurnirTeam;
use App\Models\TurnirTeamGroup;
use App\Models\TurnirTour;
use App\Models\User;
use App\Services\TurnirService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TurnirController extends Controller
{
    public function team()
    {
        $month = Carbon::now()->startOfMonth()->format('Y-m-d');
        $teams = TurnirTeam::with(['turnir_member' => function ($q) use ($month) {
            $q->whereDate('month', $month);
            $q->orderBy('tour');
        }, 'turnir_member.user' => function ($u) {
            $u->select('id', 'first_name', 'last_name');
        }])->get();
        $memIds = TurnirMember::whereDate('month', $month)->pluck('user_id')->toArray();
        $users = User::whereIn('status', [0, 1])
            ->whereNotIn('id', $memIds)
            ->orderBy('first_name', 'ASC')
            ->get();
        return view('turnir.team', [
            'teams' => $teams,
            'users' => $users
        ]);
    }

    public function group()
    {
        $month = Carbon::now()->startOfMonth()->format('Y-m-d');
        $teamIds = TurnirTeamGroup::whereDate('month', $month)->pluck('team_id');
        $groups = TurnirGroup::with(['team_groups' => function ($q) use ($month) {
            $q->whereDate('month', $month);
        }, 'team_groups.group'])
            ->get();
        $teams = TurnirTeam::whereNotIn('id', $teamIds)->get();
        return view('turnir.group', [
            'teams' => $teams,
            'groups' => $groups
        ]);
    }

    public function memberStore(Request $request)
    {
        $member = TurnirMember::where('user_id', $request->user_id)
            ->whereDate('month', $request->month)
            ->first();
        $count = TurnirTeam::with(['turnir_member' => function ($q) use ($request) {
            $q->whereDate('month', $request->month)->where('tour', 1);
        }])->where('id', $request->team_id)
            ->first();

        if ($count->turnir_member->count() < 2 && !$member) {
            for ($i = 1; $i <= 3; $i++) {
                $member = new TurnirMember;
                $member->team_id = $request->team_id;
                $member->user_id = $request->user_id;
                $member->month = $request->month;
                $member->tour = $i;
                $member->save();
            }
        }
        return redirect()->back();
    }

    public function teamGroupStore(Request $request)
    {
        $teamGroup = TurnirTeamGroup::where('team_id', $request->team_id)
            ->whereDate('month', $request->month)
            ->first();
        $count = TurnirGroup::with(['team_groups' => function ($q) use ($request) {
            $q->whereDate('month', $request->month);
        }])->where('id', $request->group_id)
            ->first();
        if ($count->team_groups->count() < 4 && !$teamGroup) {
            $member = new TurnirTeamGroup();
            $member->team_id = $request->team_id;
            $member->group_id = $request->group_id;
            $member->month = $request->month;
            $member->save();
        }
        return redirect()->back();
    }

    public function groupState()
    {
        return view('turnir.standing');
    }

    public function turnirTour()
    {
        $month = Carbon::now()->startOfMonth()->format('Y-m-d');

        $tours = TurnirTour::whereDate('month', $month)->orderBy('tour', "ASC")->get();
        // return $tours;
        return view('turnir.tour', compact('tours'));
    }

    public function turnirTourStore(Request $request)
    {
        $tour = $request->tour;
        $date_begin = $request->date_begin;
        $date_end = $request->date_end;
        $month = $request->month;
        $tourDate = TurnirTour::whereDate('date_begin', '>=', $date_begin)
            ->whereDate('date_end', '<=', $date_end)
            ->first();
        $tourT = TurnirTour::whereDate('month', $month)
            ->where('tour', $tour)
            ->first();
        if (!$tourDate && !$tourT) {
            TurnirTour::create([
                'tour' => $tour,
                'date_begin' => $date_begin,
                'date_end' => $date_end,
                'month' => $month,
                'title' => $request->title
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }
    public function turnirTourUpdate(Request $request)
    {
        $begin = $request->begin;
        $end = $request->end;
        $tour = $request->tour_id;
        $month = Carbon::now()->startOfMonth()->format("Y-m-d");
        TurnirTour::where('tour', $tour)->whereDate('month', $month)->update([
            'date_begin' => $begin,
            'date_end' => $end,
            'title' => $request->title
        ]);
        TurnirStanding::where('tour', $tour)->whereDate('month', $month)->update([
            'date_begin' => $begin,
            'date_end' => $end,
        ]);
        return redirect()->back();
    }

    public function turnirPlayoff()
    {
        $service = new TurnirService;
        $teams = $service->getTeamsWithoutBattle(1);
        $battles = $service->getStandings(1);
        return view('turnir.playoff', compact('teams', 'battles'));
    }

    public function turnirPlayoffStore(Request $request)
    {
        if ($request->team1_id == $request->team2_id) {
            return redirect()->back();
        }
        $service = new TurnirService;
        $service->storeMembersPointsBattles($request, 1);  
        return redirect()->back();
    }

    public function turnirGames()
    {
        $service = new TurnirService;
        $teams = $service->getTeamsWithoutBattle(0);
        $battles = $service->getStandings(0);
        return view('turnir.games', compact('teams', 'battles'));
    }

    public function turnirGamesStore(Request $request)
    {
        if ($request->team1_id == $request->team2_id) {
            return redirect()->back();
        }
        $service = new TurnirService;
        $service->storeMembersPointsBattles($request, 0);  
        return redirect()->back();
    }

    public function groupStateStore(Request $request)
    {
        $month = $request->month;

        $groups = TurnirGroup::with(['team_group' => function ($team) {
            $team->orderBy('id', 'ASC');
        }])->get();
        $teams = [];
        $begin = $request->begin_date;


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
