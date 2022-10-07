<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PillQuestion;
use App\Models\ConditionQuestion;
use App\Models\KnowledgeQuestion;

class KnowledgeQuestionController extends Controller
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
        $knowledge_questions = KnowledgeQuestion::with('condition_question')->get();
        return view('knowledge-question.create',compact('pill_questions','condition_questions','knowledge_questions'));
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
            'condition_question_id'=>'required',
            'knowledge_question'=>'required',
        ]);

        $data = $request->all();
        $new_knowledge_question = new KnowledgeQuestion([
            'condition_question_id' => $data['condition_question_id'],
            'name' => $data['knowledge_question'],
            'created_at' => date_now(),
        ]);
        $new_knowledge_question->save();
        if($new_knowledge_question->id)
        {
            return redirect()->back()->with('p_q_id',$data['pill_question_id']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
