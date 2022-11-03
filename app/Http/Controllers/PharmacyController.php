<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmacyUser;
use App\Models\Pharmacy;
use App\Models\Region;
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
    public function userPharma(Request $request)
    {
        $new = new PharmacyUser([
            'user_id' => $request->user_id,
            'pharma_id' => $request->team_id,
        ]);

        $new->save();
        return redirect()->back();
    }
    public function userPharmaDelete(Request $request)
    {
        // return $request;
        $new = PharmacyUser::where('user_id',$request->user_id)
            ->where('pharma_id',$request->team_id)
            ->delete();
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

    public function chart(Request $request)
    {
        if ($request->time == 'a_today') {
            $date_begin = date_now();
            $date_end = date_now();
        }
        elseif ($request->time == 'a_week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
        }
        elseif ($request->time == 'a_month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
        }
        elseif ($request->time == 'a_year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
        }
        elseif ($request->time == 'a_all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
        }
        else{
            $date_begin = date('Y-m-d',(strtotime (substr($request->time,0,10) ) ));
            $date_end = date('Y-m-d',(strtotime ( substr($request->time,11) ) ));
        }
        if ($request->user == 'all') {
            if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $users = DB::table('tg_user')
                    ->where('tg_user.admin',FALSE)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
            else{
                $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
                    $users = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->where('tg_user.admin',FALSE)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
        }
        if ($request->user !== 'all') {
            $userarrayreg[] = $request->user;
        }
        $farm_sum_json=[];
            $pharmacy = DB::table('tg_smena')
            ->select('tg_smena.*')
            ->where('tg_smena.pharm_id',$request->id)
            ->whereIn('tg_user.id',$userarrayreg)
            ->whereDate('tg_smena.created_from','>=',$date_begin)
            ->whereDate('tg_smena.created_from','<=',$date_end)
            ->join('tg_user','tg_user.id','tg_smena.user_id')
            ->pluck('tg_smena.created_from');

            $day=[];
            foreach($pharmacy as $value)
            {
                $day[]=date('Y-m-d',(strtotime ( $value ) ));
            }
            

            // $product = DB::table('tg_productssold')
            //     ->whereDate('tg_productssold.created_at','>=',$date_begin)
            //     ->whereDate('tg_productssold.created_at','<=',$date_end)
            //     ->whereIn('user_id',$pharmacy)
            //     ->sum(DB::raw('price_product * number'));
            // $farm_sum_json[] = array('id' => $value->id,'name' => $value->name, 'sum' => $product,'img' => $value->image,'phone'=>$value->phone_number,'size'=>$value->volume,'region'=>$value->region);
        
        return $day;
    }
    public function pharmacyUser()
    {
        $pharmacy = Region::with('pharmacy')->get();
        $pusers = PharmacyUser::select('tg_user.id','tg_user.first_name','tg_user.last_name','tg_pharmacy_users.*')
        ->join('tg_user','tg_user.id','tg_pharmacy_users.user_id')
        ->get();
        $users = DB::table('tg_user')->where('admin',FALSE)->get();
        // return $pharmacy;
        return view('pharmacy.index',compact('pharmacy','users','pusers'));
    }
}
