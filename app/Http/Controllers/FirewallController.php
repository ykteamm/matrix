<?php

namespace App\Http\Controllers;

use App\Models\FirewallSold;
use App\Models\Order;
use App\Models\Premya;
use App\Models\PremyaTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FirewallController extends Controller
{
    public function index()
    {
        $firewalls = DB::table('firewall_solds')->where('active',0)->distinct('order_id')->pluck('order_id')->toArray();

        $fire_arrays = [];

        foreach ($firewalls as $key => $value) {
            
            $fire = FirewallSold::with('user','pharmacy','medicine')->where('order_id',$value)->get();

            $fire_arrays[$value] = $fire;

        }
        return view('firewall.index',compact('fire_arrays'));
    }

    public function firewallConfirm($id,$status)
    {
        if($status == 1)
        {
            $fire = FirewallSold::where('order_id',$id)->get();

            foreach ($fire as $key => $value) {
                    
                    $sold = DB::table('tg_productssold')->insertGetId([
                        'number' => $value->number,
                        'created_at' => $value->created_at,
                        'medicine_id' => $value->medicine_id,
                        'user_id' => $value->user_id,
                        'order_id' => $value->order_id,
                        'price_product' => $value->price,
                        'is_active' => TRUE,
                        'pharm_id' => $value->pharmcy_id,
                    ]);
            }

            $fireup = FirewallSold::where('order_id',$id)->update([
                'confirm_by' => Session::get('user')->id,
                'active' => 1,
            ]);

            $prodaja = DB::table('tg_productssold as p')
            ->selectRaw('COALESCE(SUM(p.number * p.price_product),0) as prodaja')
            ->where('p.user_id', Auth::id())
            ->whereDate('p.created_at', date("Y-m-d"))
            ->value('prodaja');

        $exists = PremyaTask::where('user_id',Auth::id())->whereDate('created_at','=',date('Y-m-d'))->first();
        if($exists)
        {
            $premya = Premya::find($exists->premya_id);

        }else{
            $ids = PremyaTask::where('user_id',Auth::id())->pluck('premya_id')->toArray();
            $premya = Premya::whereNotIn('id',$ids)->orderBy('id','ASC')->first();
        }


        if($premya)
        {
            $first = PremyaTask::where('user_id',Auth::id())
            ->whereDate('created_at', date('Y-m-d'))
            ->first();

            // return $premya;  

            if($first)
            {
                $first->prodaja = $prodaja;
                $first->save();
            }else{
                if($premya->task <= $prodaja)
                {
                    PremyaTask::create([
                        'user_id' => Auth::id(),
                        'premya_id' => $premya->id,
                        'prodaja' => $prodaja
                    ]);
                }

            }
        }

        }else{
            $fire = FirewallSold::where('order_id',$id)->delete();
            $order = Order::find($id)->delete();
        }   
        return redirect()->back();
    }
}
