<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQuestion;
use App\Models\PillQuestion;
use App\Models\ConditionQuestion;
use App\Models\KnowledgeQuestion;

class ElchiController extends Controller
{
    public function elchiKnow($id)
    {
        $user_question = UserQuestion::where('user_id',$id)->first();
        $question_step1 = [];
        $question_step3 = [];
        $questions = [];
        foreach(json_decode($user_question->step1) as $key => $value)
        {
            foreach($value as $item)
            {

                $question_step1[] = PillQuestion::where('id',$item)->first();
            }
        }
        foreach(json_decode($user_question->step3) as $key => $value)
        {
            foreach($value as $item)
            {

                $question_step3[] = PillQuestion::where('id',$item)->first();
            }
        }
        foreach(json_decode($user_question->question_step) as $key => $value)
        {
            foreach($value as $item)
            {

                $questions[] = KnowledgeQuestion::where('id',$item)->first();
            }
        }
        // return $question_step3;
        $asd = 123; 
        return view('know-grade',compact('asd','question_step1','question_step3','questions','id'));
    }

    public function knowGradeStore(Request $request)
    {
        return $request;
    }

}
