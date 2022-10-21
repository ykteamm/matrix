<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;
use App\Models\PillQuestion;
use App\Models\KnowledgeQuestion;
use App\Models\UserQuestion;
class GradeController extends Controller
{
    public function allGrade()
    {
        $all_elchi = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            ->select('tg_region.id','tg_region.name as v_name','tg_user.username','tg_user.id as user_id','tg_user.last_name','tg_user.first_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('tg_user.admin','DESC')->get();

        $questions = DB::table('tg_question')
        ->select('tg_question.id as id','tg_department.id as did','tg_question.name as qname')
        ->where('tg_department.status',1)
        ->join('tg_department','tg_department.id','tg_question.department_id')
        ->get();
        // return $questions;

        $departments = DB::table('tg_department')
        ->where('tg_department.status',1)
        ->get();

        $grades_user = DB::table('tg_grade')
        ->select('tg_grade.grade','tg_grade.question_id as qid','tg_grade.user_id','tg_department.id as tid')
        ->whereDate('tg_grade.created_at',Carbon::now()->format('Y-m-d'))
        ->join('tg_question','tg_question.id','tg_grade.question_id')
        ->join('tg_department','tg_department.id','tg_question.department_id')
        ->where('tg_grade.teacher_id',Session::get('user')->id)
        ->get();
        $grades=[];
        foreach($grades_user as $gar)
        {
            $id = $gar->user_id.$gar->tid.$gar->qid;
            $grades[$id] = $gar;
        }
        $question_step1 = [];
        $know_questions = [];
        foreach($all_elchi as $items)
        {
            $user_question = UserQuestion::where('user_id',$items->user_id)->first();
            $json_arr1 = json_decode($user_question->step1);
            $json_arr2 = json_decode($user_question->question_step);
            foreach($json_arr1 as $key => $value)
            {
                foreach($value as $item)
                {
                    $ids = $items->user_id.$item;
                    $question_step1[$ids] = PillQuestion::where('id',$item)->first();
                }
            }
            foreach($json_arr2 as $key => $value)
            {
                foreach($value as $item)
                {
                    $ids = $items->user_id.$item;
                    $know_questions[$ids] = KnowledgeQuestion::where('id',$item)->first();
                }
            }
        }

        return view('all-grade',compact('departments','all_elchi','questions','grades','question_step1','know_questions'));
    }
    public function allGradeStore(Request $request)
    {
        $inputs = $request->all();
        $teacher_id = Session::get('user')->id;
        unset($inputs['_token']);
        foreach($inputs as $item)
        {
            if($item != null)
            {
                $grade = json_decode($item)[0];
            // return $grade[0];

            DB::table('tg_grade')->insert([
                'grade' => $grade->grade,
                'teacher_id' => $teacher_id,
                'question_id' => $grade->quest_id,
                'user_id' => $grade->user_id,
                'created_at' => date_now(),
                'save' => FALSE,

            ]);
            }
            
        }

        return redirect()->back();
    }

    public function allGradeStoreStep1(Request $request)
    {
        $inputs = $request->all();
        $teacher_id = Session::get('user')->id;
        unset($inputs['_token']);
        foreach($inputs as $item)
        {
            if($item != null)
            {
                $grade = json_decode($item)[0];
            // return $grade[0];
            if(isset($grade->quest_id))
                {
                    DB::table('tg_knowledge_grades')->insert([
                        'grade' => $grade->grade,
                        'teacher_id' => $teacher_id,
                        'pill_id' => $grade->quest_id,
                        'user_id' => $grade->user_id,
                        'created_at' => date_now(),
                    ]);
                }else{
                    DB::table('tg_knowledge_grades')->insert([
                        'grade' => $grade->grade,
                        'teacher_id' => $teacher_id,
                        'knowledge_question_id' => $grade->know_quest_id,
                        'user_id' => $grade->user_id,
                        'created_at' => date_now(),
                    ]);
                }
            }
            
        }

        return redirect()->back();
    }
    public function allGradeStoreStep3(Request $request)
    {
        $inputs = $request->all();
        // return $inputs;
        $teacher_id = Session::get('user')->id;
        unset($inputs['_token']);
        foreach($inputs as $item)
        {
            if($item != null)
            {
                $grade = json_decode($item)[0];
            // return $grade[0];

            DB::table('tg_knowledge_grades')->insert([
                'grade' => $grade->grade,
                'teacher_id' => $teacher_id,
                'knowledge_question_id' => $grade->quest_id,
                'user_id' => $grade->user_id,
                'created_at' => date_now(),
            ]);
            }
            
        }

        return redirect()->back();
    }

}
