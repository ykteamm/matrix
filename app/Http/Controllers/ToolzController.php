<?php

namespace App\Http\Controllers;

use App\Models\KingSold;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolzController extends Controller
{
    public function selfi()
    {
        $shifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->orderBy('id','DESC')->get();
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
        $solds = KingSold::with('order','order.sold','order.sold.medicine','order.user')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('image','!=','add')
        ->orderBy('id','DESC')->get();
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.king-sold',compact('solds','host'));

    }
    public function kingSoldAnsver(Request $request)
    {
        // return $request->id;
        $order_id = KingSold::find($request->id)->order_id;
        // return $order_id;
        $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->where('tg_productssold.order_id',$order_id)->get();
        $add = floor($summa[0]->allprice/200000)-1;
        if($add != 0)
        {
            for ($i=1; $i <= $add; $i++) { 
                $new = new KingSold([
                    'order_id' => $order_id,
                    'image' => 'add',
                    'admin_check' => 1
                ]);
                $new->save();
            }
        }
        $new = KingSold::where('id',$request->id)->update([
            'admin_check' => $request->ansver
        ]);

        return [
            'response' => 200,
        ];
    }
}
