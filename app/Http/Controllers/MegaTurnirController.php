<?php

namespace App\Http\Controllers;

use App\Models\MegaTurnirTeacher;
use App\Models\MegaTurnirTeacherStudent;
use App\Models\MegaTurnirTeamBattle;
use App\Models\MegaTurnirUserBattle;
use App\Models\ProductSold;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MegaTurnirController extends Controller
{
    public function teacher()
    {

        $users = User::all();

        $teachers = MegaTurnirTeacher::all();

        return view('mega-turnir.teacher',[
            'users' => $users,
            'teachers' => $teachers,
        ]);
        
    }

    public function teacherSave(Request $request)
    {
        $teach = new MegaTurnirTeacher;
        $teach->teacher_id = $request->teacher_id;
        $teach->save();

        return redirect()->back();
    }

    public function team()
    {

        $users = User::all();

        $teachers = MegaTurnirTeacher::with('teacher_shogird')->get();

        // dd($teachers[0]->teacher_shogird[0]->shogird);

        // rerer
        return view('mega-turnir.team',[
            'users' => $users,
            'teachers' => $teachers,
        ]);
        
    }

    public function teamSave(Request $request)
    {
        $teach = new MegaTurnirTeacherStudent;
        $teach->teacher_id = $request->teacher_id;
        $teach->shogird_id = $request->shogird_id;
        $teach->save();

        return redirect()->back();
    }

    public function teamBattle()
    {

        $id1 = MegaTurnirTeamBattle::where('tour',9)->pluck('user1id')->toArray();
        $id2 = MegaTurnirTeamBattle::where('tour',9)->pluck('user2id')->toArray();

        $ids = array_merge($id1,$id2);

        $teachers = MegaTurnirTeacher::with('teacher_shogird')->get();

        $battles = MegaTurnirTeamBattle::with('user1','user2')->orderBy('id','ASC')->get();


        return view('mega-turnir.team-battle',[
            'teachers' => $teachers,
            'ids' => $ids,
            'battles' => $battles,
        ]);
    }

    public function teamBattleSave(Request $request)
    {
        $teach = new MegaTurnirTeamBattle;
        $teach->user1id = $request->user1id;
        $teach->user2id = $request->user2id;
        $teach->begin = '2023-11-16';
        $teach->end = '2023-11-18';
        $teach->tour = 10;
        $teach->save();

        return redirect()->back();
    }

    public function userBattle()
    {

        
        // $id11 = MegaTurnirTeamBattle::where('tour',4)->pluck('user1id')->toArray();
        // $id22 = MegaTurnirTeamBattle::where('tour',4)->pluck('user2id')->toArray();

        $id11 = [];
        $id22 = [];


        $ids111 = array_merge($id11,$id22);

        $id1 = MegaTurnirUserBattle::where('tour',10)->pluck('user1id')->toArray();
        $id2 = MegaTurnirUserBattle::where('tour',10)->pluck('user2id')->toArray();

        $ids11 = array_merge($id1,$id2);

        $user_ids = User::pluck('id')->toArray();

        $ids = [];


        foreach ($user_ids as $key => $value) {
            if(in_array($value,$ids111) || in_array($value,$ids11))
            {
                $sold = 0;
            }else{
                $sold = ProductSold::whereDate('created_at','>=','2023-09-01')
                ->where('user_id',$value)
                ->sum(DB::raw('number*price_product'));
            }
            

            if($sold > 0)
            {
                $ids[] = $value;
            }
        }

        

        $users = User::whereIn('id',$ids)->get();

        // return $users;

        $battles = MegaTurnirUserBattle::with('user1','user2')->orderBy('id','ASC')->get();


        return view('mega-turnir.user-battle',[
            'users' => $users,
            'ids' => $ids,
            'battles' => $battles,
        ]);
    }

    public function userBattleSave(Request $request)
    {
        $teach = new MegaTurnirUserBattle;
        $teach->user1id = $request->user1id;
        $teach->user2id = $request->user2id;
        $teach->begin = '2023-11-16';
        $teach->end = '2023-11-18';
        $teach->tour = 10;
        $teach->save();

        return redirect()->back();
    }
}
