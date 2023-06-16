<?php

namespace App\Services;

use App\Models\TurnirMember;
use App\Models\TurnirPoint;
use App\Models\TurnirStanding;
use App\Models\TurnirTeam;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TurnirService
{
    public $tour;
    public $date;
    public $month;

    public function __construct()
    {
        $this->tour = $this->getTour();
        $this->date =  date("Y-m-d");
        $this->month = Carbon::now()->startOfMonth()->format('Y-m-d');
    }

    public function getTour($date = NULL)
    {
        return DB::table('turnir_tours')
            ->whereDate('date_begin', '<=', $date ?? date("Y-m-d"))
            ->whereDate('date_end', '>=', $date ?? date("Y-m-d"))
            ->first();
    }
    public function getNextTour($date = NULL)
    {
        return DB::table('turnir_tours')
            ->whereDate('date_begin', '>=', $date ?? date("Y-m-d"))
            ->orderBy('date_begin', "ASC")
            ->first();
    }

    public function getTeamUids($teamId, $tour, $month)
    {
        return DB::table('turnir_teams')
            ->leftJoin('turnir_members', 'turnir_members.team_id', 'turnir_teams.id')
            ->where('turnir_teams.id', $teamId)
            ->where('turnir_members.tour', $tour)
            ->where('turnir_members.month', $month)
            ->pluck('turnir_members.user_id');
    }

    public function getTeamIds($month, $team, $s, $tour)
    {
        return TurnirStanding::where('status', $s)
            ->whereDate('month', $month)
            ->where('tour', $tour)
            ->pluck($team);
    }
    public function getTeamsIds($month, $s, $tour)
    {
        $team1Ids = $this->getTeamIds($month, 'team1_id', $s, $tour)->toArray();
        $team2Ids = $this->getTeamIds($month, 'team2_id', $s, $tour)->toArray();
        return array_merge($team1Ids, $team2Ids);
    }
    

    public function storeMembersPointsBattles($request, $status)
    {
        $tour = $this->getNextTour();
        $month = $this->month;
        // $team1Uids = $this->getTeamUids($request->team1_id, $tour->tour-1, $month);
        // $team2Uids = $this->getTeamUids($request->team2_id, $tour->tour-1, $month);
        // dd($request->all(), $status);
        // TurnirMember::create([
        //     'team_id' => $request->team1_id,
        //     'user_id' => $team1Uids[0],
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        // TurnirMember::create([
        //     'team_id' => $request->team1_id,
        //     'user_id' => $team1Uids[1],
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        // TurnirMember::create([
        //     'team_id' => $request->team2_id,
        //     'user_id' => $team2Uids[0],
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        // TurnirMember::create([
        //     'team_id' => $request->team2_id,
        //     'user_id' => $team2Uids[1],
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        // TurnirPoint::create([
        //     'point' => 0,
        //     'team_id' =>  $request->team1_id,
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        // TurnirPoint::create([
        //     'point' => 0,
        //     'team_id' =>  $request->team2_id,
        //     'tour' => $tour->tour,
        //     'month' => $month
        // ]);
        TurnirStanding::create([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'win' => null,
            'lose' => null,
            'tour' => $tour->tour,
            'date_begin' => $tour->date_begin,
            'date_end' => $tour->date_end,
            'status' => $status,
            'month' => $month,
            'ends' => 0,
        ]); 
    }

    public function getTeamsWithoutBattle($status)
    {
        $month = $this->month;
        $tour = $this->getNextTour();
        $teamIds = $this->getTeamsIds($month, $status, $tour->tour);
        // dd($teamIds);
        return TurnirTeam::with(['turnir_member' => function ($q) use ($month) {
            $q->whereDate('month', $month);
            $q->orderBy('tour');
        }, 'turnir_member.user' => function ($u) {
            $u->select('id', 'first_name', 'last_name');
        }])
            ->where('status', $status)
            ->whereNotIn('id', $teamIds)
            ->get();
    }

    public function getStandings($status)
    {
        $month = $this->month;
        $tour = $this->getNextTour();
        return TurnirStanding::select('id', 'team1_id', 'team2_id')
        ->with([
            'team1' => function ($q) use ($month, $status) {
                $q->select('id')->where('status', $status);
                $q->with(['users' => function ($b) use ($month) {
                    $b->whereDate('month', $month)->groupBy('tg_user.id', 'turnir_members.team_id')
                        ->selectRaw('tg_user.id, tg_user.first_name as f, tg_user.last_name as l, tg_user.image_url as img, turnir_members.team_id')
                        ->leftJoin('tg_user', 'tg_user.id', 'turnir_members.user_id');
                }]);
            },
            'team2' => function ($q) use ($month, $status) {
                $q->select('id', 'status')->where('status', $status);
                $q->with(['users' => function ($b) use ($month) {
                    $b->whereDate('month', $month)->groupBy('tg_user.id', 'turnir_members.team_id')
                        ->selectRaw('tg_user.id, tg_user.first_name as f, tg_user.last_name as l, tg_user.image_url as img, turnir_members.team_id')
                        ->leftJoin('tg_user', 'tg_user.id', 'turnir_members.user_id');
                }]);
            }
        ])
        ->where('status', $status)
        ->where('tour', $tour->tour)
        ->whereDate('month', $month)
        ->get();        
    }
}
