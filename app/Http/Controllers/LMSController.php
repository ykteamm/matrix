<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LMSController extends Controller
{
    public function index()
    {
        $course = DB::table('lms_courses')->where('status',0)->first();
        $module = DB::table('lms_module')->where('course_id',$course ? $course->id : null)->first();
        $lesson = DB::table('lms_lesson')->where('module_id',$module ? $module->id : null)->first();
        $group_test = DB::table('lms_group_tests')->where('lesson_id',$lesson ? $lesson->id : null)->first();

        $answer_check = DB::table('lms_answer_check')
            ->where([
                'course_id'=>$course ? $course->id: null,
                'module_id'=>$module ? $module->id: null,
                'lesson_id'=>$lesson ? $lesson->id : null,
            ])
            ->where('foiz', '>=', $group_test ? $group_test->ball : null)
            ->get();
//        return $answer_check;

        $answer_user_id = [];
        $test = [];
        foreach ($answer_check as $ids){
            $answer_user_id[] = $ids->user_id;
            $data = [
                'user_id' => $ids->user_id,
                'foiz' => $ids->foiz,
            ];
            $test[] = $data;
        }

//        return $test;
//        return $answer_user_id;
        $users_passed = DB::table('lms_passed')
            ->where([
                'course_id'=> $course->id,
                'module_id'=>$module->id,
                'lesson_id'=>$lesson->id,
                'pass_status'=>1,
            ])
            ->whereIn('user_id',$answer_user_id)
            ->get();

        $passed_user_id = [];
        foreach ($users_passed as $user)
        {
            $passed_user_id[] = $user->user_id;
        }

        $user_check = DB::table('lms_users_check')->pluck('user_id')->toArray();

//        return $user_check;

        $users = DB::table('lms_users')
            ->whereIn('id',$passed_user_id)
            ->whereNotIn('id',$user_check)
            ->get();

//        return $users;

        return view('lms.index',compact('users','answer_check','test'));
    }

    public function UserCheck(Request $request)
    {
        $data = $request->all();
        $user_check = DB::table('lms_users_check')
            ->insert([
                'user_id'=>$data['user_id'],
                'video'=>$data['video'],
                'one_day_apteka'=>$data['one_day_apteka'],
                'test'=>$data['test'],
                'created_at'=> now(),
            ]);
        $lms_user = DB::table('lms_users')->where('id',$data['user_id'])
            ->update([
                'status'=>1,
                'date_joined'=>now(),
                'date_register'=>now(),
            ]);

        return redirect(route('lms-index'));
    }
}
