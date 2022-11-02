<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmacyUser;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
use Session;

class PharmacyController extends Controller
{
    public function pharmacyList($time)
    {
        if ($time == 'today') {
            $date_begin = today();
            $date_end = today();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        foreach ($regions as $key => $value) {
            // if (is_numeric($key)){
           $r_id_array[] = $value->id;
            // }
        }

        }else{
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        // return $r_id_array;
        $pharmacy = DB::table('tg_pharmacy')->get();
        $farm_json=[];
        $farm_sum_json=[];
        foreach ($pharmacy as $key => $value) {
            $pharmacy = DB::table('tg_smena')
            ->where('tg_smena.pharm_id',$value->id)
            ->whereIn('tg_region.id',$r_id_array)
            ->join('tg_user','tg_user.id','tg_smena.user_id')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->distinct()
            ->pluck('tg_smena.user_id');

            $product = DB::table('tg_productssold')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->whereIn('user_id',$pharmacy)
                ->sum(DB::raw('price_product * number'));
            $farm_sum_json[] = array('id' => $value->id,'name' => $value->name, 'sum' => $product,'img' => $value->image,'phone'=>$value->phone_number,'size'=>$value->volume,'region'=>$value->region);
        }
        return view('pharmacy',compact('farm_sum_json','dateText'));
    }
    public function pharmaUserStore(Request $request,$id)
    {
        $new = new PharmacyUser([
            'user_id' => $id,
            'pharma_id' => $request->pharma_id
        ]);

        $new->save();
        return redirect()->back();
    }
    public function userPharmaStore(Request $request,$id)
    {
        $new = new PharmacyUser([
            'user_id' => $request->user_id,
            'pharma_id' => $id
        ]);

        $new->save();
        return redirect()->back();
    }
    public function pharmacy($id)
    {
        $pharma = Pharmacy::find($id);


        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();

        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $users = DB::table('tg_user')
        ->where('tg_user.admin',FALSE)
        
        ->get();


        }else{
            $users = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            ->whereIn('region_id',$r_id_array)->get();

        }
        return view('pharmacy-index',compact('pharma','users'));
    }

}
