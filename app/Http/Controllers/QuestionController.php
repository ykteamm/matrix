<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = DB::table('tg_question')->where('grade','!=',6)->get();
        $departichki = DB::table('tg_department')->whereIn('status',[1])->get();
        $departtashqi = DB::table('tg_department')->whereIn('status',[2])->get();

        return view('question.create',compact('question','departichki','departtashqi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // return $data['bolim'];
        if($data['bolim'] == 'Ichki')
        {
            $save = DB::table('tg_question')->insert([
                'name' => $data['bname'],
                'grade' => 0,
                'department_id' => $data['bolimid'],
                'created_at' => Carbon::now(),
            ]);
        }else{
            $save = DB::table('tg_question')->insert([
                'name' => $data['bname'],
                'grade' =>  $data['bball'],
                'department_id' => $data['bolimid2'],
                'created_at' => Carbon::now(),
            ]);
        }
        $question = DB::table('tg_question')->where('grade','!=',6)->get();
        $departichki = DB::table('tg_department')->whereIn('status',[1])->get();
        $departtashqi = DB::table('tg_department')->whereIn('status',[2])->get();

        // return $depart;
        return view('question.create',compact('question','departichki','departtashqi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = DB::table('tg_question')->where('id',$id)->first();
        if($question->grade == 0)
        {
            $depart = DB::table('tg_department')->whereIn('status',[1])->get();
        }else{
            $depart = DB::table('tg_department')->whereIn('status',[2])->get();

        }

        // return $question;
        return view('question.edit',compact('question','depart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(isset($request->bball))
        {
            $dep = DB::table('tg_question')->where('id',$id)->update([
                'name' => $request->bname,
                'department_id' => $request->bolimid,
                'grade' => $request->bball,
            ]);
        }else{
            $dep = DB::table('tg_question')->where('id',$id)->update([
                'name' => $request->bname,
                'department_id' => $request->bolimid,
            ]);
        }
        
        $question = DB::table('tg_question')->where('grade','!=',6)->get();
        $departichki = DB::table('tg_department')->whereIn('status',[1])->get();
        $departtashqi = DB::table('tg_department')->whereIn('status',[2])->get();

        // return $depart;
        return view('question.create',compact('question','departichki','departtashqi'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        // $delete = DB::table('tg_clientgrade')->where('question_id',$id)->delete();
        // $delete = DB::table('tg_question')->where('id',$id)->delete();

// return $delete;
        $question = DB::table('tg_question')->where('id',$id)->first();
        if($question->grade == 0)
        {
            $delete = DB::table('tg_grade')->where('question_id',$id)->delete();

        }else{
            $delete = DB::table('tg_clientgrade')->where('question_id',$id)->delete();

        }

        $delete = DB::table('tg_question')->where('id',$id)->delete();
        // $question = DB::table('tg_question')->where('grade','!=',6)->get();

        // return $fsdf;

        $question = DB::table('tg_question')->where('grade','!=',6)->get();
        $departichki = DB::table('tg_department')->whereIn('status',[1])->get();
        $departtashqi = DB::table('tg_department')->whereIn('status',[2])->get();

        // return $depart;
        return view('question.create',compact('question','departichki','departtashqi'));
        // if($delete){
        //     return redirect()->back()->with('message',(__('message.delete_success')));
        // }else{
        //     return redirect()->back()->with('message',(__('message.delete_error')));
        // }
    }
}
