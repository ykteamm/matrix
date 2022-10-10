<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knowledge;
use App\Models\PillQuestion;
use App\Models\ConditionQuestion;
use App\Models\KnowledgeQuestion;
use Illuminate\Support\Str;
class PillQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // for ($i=0; $i < 50; $i++) { 
            // $randomString = Str::random(8);
            // $new_pill_question = new PillQuestion([
            //     'name' => 'Dori'.$randomString,
            //     'knowledge_id' => 1,
            //     'created_at' => date_now(),
            // ]);
            // $new_pill_question->save();
        // }
        // $randomString = Str::random(8);
        // dd($randomString);
        // $pill_questions = ConditionQuestion::all();
        // foreach($pill_questions as $item)
        // {
        //     for ($i=0; $i < 5; $i++) { 
        //         $randomString = Str::random(8);

        //         $new_condition_question = new KnowledgeQuestion([
        //             'condition_question_id' => $item->id,
        //             'name' => 'Asosiy'.$randomString,
        //             'created_at' => date_now(),
        //         ]);
        //         $new_condition_question->save();
        //     }
        // }
        $knowledge = Knowledge::all();
        $pill_questions = PillQuestion::all();
        return view('pill-question.create',compact('knowledge','pill_questions'));
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
            'knowledge_id'=>'required',
            'pill_question'=>'required',
        ]);

        $data = $request->all();
        $new_pill_question = new PillQuestion([
            'name' => $data['pill_question'],
            'knowledge_id' => $data['knowledge_id'],
            'created_at' => date_now(),
        ]);
        $new_pill_question->save();
        if($new_pill_question->id)
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
        $pill_question = PillQuestion::find($id);
        return view('pill-question.edit',compact('pill_question'));
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
            'pill_question'=>'required',
        ]);
        $data = $request->all();
        $update_pill_question = PillQuestion::where('id',$id)->update([
            'name' => $data['pill_question'],
            'updated_at' => date_now(),
        ]);

        if($update_pill_question)
        {
            return redirect()->route('pill-question.create')->with('success','Ma\'lumot saqlandi');
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
        $delete = PillQuestion::find($id)->delete();
        if($delete){
            return redirect()->back()->with('message',(__('message.delete_success')));
        }else{
            return redirect()->back()->with('message',(__('message.delete_error')));
        }
    }
}
