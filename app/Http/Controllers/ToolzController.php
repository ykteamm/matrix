<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ToolzController extends Controller
{
    public function selfi()
    {
        $shifts = Shift::with('user','pharmacy','user.region')->whereNull('admin_check')->orderBy('id','ASC')->get();
        $host = substr(request()->getHttpHost(),0,4);
        return view('toolz.selfi',compact('shifts','host'));
    }
    public function shiftAnsver(Request $request)
    {
        $new = Shift::where('id',$request->id)->update([
            'admin_check' => array('check' => $request->ansver)
        ]);

        return [
            'response' => 200,
        ];
    }
}
