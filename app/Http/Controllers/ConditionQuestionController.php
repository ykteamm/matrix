<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PillQuestion;
use App\Models\ConditionQuestion;

class ConditionQuestionController extends Controller
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
        $pill_questions = PillQuestion::all();
        $condition_questions = ConditionQuestion::with('pill_question')->get();
        return view('condition-question.create',compact('pill_questions','condition_questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pill_question_id'=>'required',
            'condition_question'=>'required',
        ]);

        $data = $request->all();
        $new_condition_question = new ConditionQuestion([
            'pill_question_id' => $data['pill_question_id'],
            'name' => $data['condition_question'],
            'created_at' => date_now(),
        ]);
        $new_condition_question->save();
        if($new_condition_question->id)
        {
            return redirect()->back()->with('success','Ma\'lumot saqlandi');
        }else{
            return redirect()->back()->error('error', 'Ma\'lumot saqlanmadi');
        }
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
        $condition_question = ConditionQuestion::with('pill_question')->find($id);
        $pill_questions = PillQuestion::all();

        return view('condition-question.edit',compact('condition_question','pill_questions'));
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
        $request->validate([
            'pill_question_id'=>'required',
            'condition_question'=>'required',
        ]);
        $data = $request->all();
        $update_condition_question = ConditionQuestion::where('id',$id)->update([
            'name' => $data['condition_question'],
            'pill_question_id' => $data['pill_question_id'],
            'updated_at' => date_now(),
        ]);

        if($update_condition_question)
        {
            return redirect()->route('condition-question.create')->with('success','Ma\'lumot saqlandi');
        }else{
            return redirect()->back()->error('error', 'Ma\'lumot saqlanmadi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = ConditionQuestion::find($id)->delete();
        if($delete){
            return redirect()->back()->with('message',(__('message.delete_success')));
        }else{
            return redirect()->back()->with('message',(__('message.delete_error')));
        }
    }
}
