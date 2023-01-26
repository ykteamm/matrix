<?php

namespace App\Http\Controllers;

use App\Models\KingSold;
use App\Models\Shift;
use Illuminate\Http\Request;
class ToolzController extends Controller
{
    public function selfi()
    {
        $shifts = Shift::with('user','pharmacy','user.region')->whereNull('admin_check')->orderBy('id','ASC')->get();
        $host = substr(request()->getHttpHost(),0,3);
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
    public function kingSold()
    {  
        $solds = KingSold::with('order','order.sold','order.sold.medicine','order.user')->get();
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.king-sold',compact('solds','host'));

    }
    public function kingSoldAnsver(Request $request)
    {
        $new = KingSold::where('id',$request->id)->update([
            'admin_check' => $request->ansver
        ]);

        return [
            'response' => 200,
        ];
    }
}
