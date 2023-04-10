<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
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

}
