<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\User;
use Illuminate\Http\Request;

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
}
