<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\TeachGradeStar;
use App\Models\TestReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = User::where('status',1)->get();

        $teachers_user = Teacher::orderBy('active','DESC')->get();

        return view('teacher.index',[
            'teachers' => $teachers,
            'teachers_user' => $teachers_user,
        ]);
    }


    public function store(Request $request)
    {
        $teacher = new Teacher([
            'user_id' => $request->user_id
        ]);

        $teacher->save();

        return redirect()->back();
    }

    public function shogird()
    {
        $users = User::where('status',1)->get();

        $teachers = Teacher::with('user')->where('active',1)->get();

        $teachers_user = TeacherUser::with('user','teacher')->get();

        // return $teachers_user;

        return view('teacher.shogird',[
            'teachers' => $teachers,
            'users' => $users,
            'teachers_user' => $teachers_user,
        ]);

    }

    public function shogirdUpdateTime(Request $request)
    {
        $inputs=$request->all();
        unset($inputs['_token']);
        foreach ($inputs as $id => $time) {
            TeacherUser::where('id', $id)->update([
                'week_date' => $time
            ]);
        }
        return redirect()->back();
    }

    public function shogirdStore(Request $request)
    {
        $teacher = new TeacherUser([
            'teacher_id' => $request->teacher_id,
            'user_id' => $request->user_id,
            'first_view' => 1,
            'day' => 0,
            'week_date' => date('Y-m-d',strtotime($request->week_date))
        ]);

        $teacher->save();

        return redirect()->back();
    }

    public function grade()
    {
        $baho = TeachGradeStar::with('tester','user')->where('star','!=',0)->orderBy('id','DESC')->get();




        $savol_baho = TestReview::with('tester','user','test')->orderBy('id','DESC')
        ->get();

        // return $savol_baho;

        return view('teacher.grade',[
            'grades' => $baho,
            'questions' => $savol_baho,
        ]);
    }
}
