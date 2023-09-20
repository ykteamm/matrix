<?php

namespace App\Http\Controllers;

use App\Models\FirewallSold;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use Illuminate\Http\Request;
use App\Models\PharmacyUser;
use App\Models\Pharmacy;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Session;

class PharmacyController extends Controller
{
    public function addPharm(Request $request) {
        $lastPharm = Pharmacy::orderBy('id', "desc")->first();
        DB::table('tg_pharmacy')->insert([
            'name' => $request->input('pharm_name'),
            'phone_number' => $lastPharm->phone_number,
            'location' => $lastPharm->location,
            'image' => $lastPharm->image,
            'image_id' => $lastPharm->image_id,
            'volume' => $lastPharm->volume,
            'sort' => $lastPharm->sort,
            'is_active' => $lastPharm->is_active,
            'created_at' => $lastPharm->created_at,
            'tg_id' => $lastPharm->tg_id,
            'day_count' => $lastPharm->day_count,
            'slug' => substr($lastPharm->slug, 0, 3).((int)substr($lastPharm->slug, 3) + 10),
            'region_id' => $request->input('region_id')
        ]);
        DB::table('tg_shablon_pharmacies')->insert([
            'shablon_id' => $request->input('shablon_id'),
            'pharmacy_id' => Pharmacy::orderBy('id', "desc")->first()->id
        ]);
        return back();
    }
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
    public function pharmacy($id,$time)
    {
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }


        // if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        // {
        // $regions = DB::table('tg_region')->get();

        // }else{
        //     $r_id_array = [];
        //     foreach (Session::get('per') as $key => $value) {
        //         if (is_numeric($key)){
        //        $r_id_array[] = $key;
        //         }
        //     }

        // }
        // if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        // {
        // $users = DB::table('tg_user')
        // ->where('tg_user.admin',FALSE)
        
        // ->get();


        // }else{
        //     $users = DB::table('tg_user')
        //     ->where('tg_user.admin',FALSE)
        //     ->whereIn('region_id',$r_id_array)->get();

        // }
        $pharma = Pharmacy::with('region')->find($id);
        // $user_sold = DB::table('tg_productssold')
        // ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as price, tg_productssold.number ,tg_medicine.name')
        // ->whereDate('tg_productssold.created_at','>=',$date_begin)
        // ->whereDate('tg_productssold.created_at','<=',$date_end)
        // ->where('tg_productssold.pharm_id',$id)
        // ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
        // ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
        // ->groupBy('tg_productssold.id', 'tg_medicine.name')
        // ->get();
        // $query = DB::table('tg_productssold')
        //     ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) AS price')
        //     ->whereDate('tg_productssold.created_at','>=', $date_begin)
        //     ->whereDate('tg_productssold.created_at','<=', $date_end)
        //     ->where('tg_productssold.pharm_id', $id)
        //     ->get();
            // return $query;
        $query = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) AS price,SUM(tg_productssold.number) AS count,tg_medicine.name, tg_medicine.id')
            ->whereDate('tg_productssold.created_at','>=', $date_begin)
            ->whereDate('tg_productssold.created_at','<=', $date_end)
            ->where('tg_productssold.pharm_id', $id)
            ->join('tg_medicine', 'tg_medicine.id', 'tg_productssold.medicine_id')
            ->groupBy('tg_medicine.id');

        $sealed = $query->get();
        // return $sealed;
        $unSealed = DB::table('tg_medicine')
            ->selectRaw('tg_medicine.name, tg_medicine.id')
            ->whereNotIn('id', $query->pluck('id'))
            ->get();

        foreach($unSealed as $item) {
            $item->count = 0;
            $item->price = 0;
            $sealed->push($item);
        }

        $user_sold = $sealed->sortBy([fn ($a, $b) => $a->id <=> $b->id]);
        // return $user_sold;
        return view('pharmacy-index',compact('pharma','user_sold','dateText'));
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
    public function pharmacyUser($time)
    {
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }
        $pharmacy = Region::with('pharmacy')->get();
        $pusers = PharmacyUser::select('tg_user.id','tg_user.first_name','tg_user.last_name','tg_pharmacy_users.*')
        ->join('tg_user','tg_user.id','tg_pharmacy_users.user_id')
        ->get();
        $users = DB::table('tg_user')->where('rm',0)->whereIn('status',[0,1])->get();

        $farm_sold = DB::table('tg_productssold')
        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.pharm_id')
        ->whereDate('tg_productssold.created_at','>=',$date_begin)
        ->whereDate('tg_productssold.created_at','<=',$date_end)
        ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
        ->groupBy('tg_productssold.pharm_id')->pluck('allprice','tg_productssold.pharm_id');

        $pharmacy_id = Pharmacy::pluck('id')->toArray();

        $arr = [];
        // $user_solds = DB::table('tg_productssold')
        //     ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.user_id')
        //     ->whereDate('tg_productssold.created_at','>=',$date_begin)
        //     ->whereDate('tg_productssold.created_at','<=',$date_end)
        //     ->join('tg_user','tg_user.id','tg_productssold.user_id')
        //     ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
        //     ->groupBy('tg_productssold.user_id')->pluck('allprice','tg_productssold.user_id')->toArray();
        //     return $user_solds;
        foreach ($pharmacy_id as $key => $value) {
            $user_solds = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.user_id')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_productssold.pharm_id','=',$value)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
            ->groupBy('tg_productssold.user_id')->pluck('allprice','tg_productssold.user_id')->toArray();
            if(count($user_solds) != 0)
            {

                // foreach ($user_solds as $key => $value) {
                //     $arr[$key] = $value;
                // }
                $arr[$value] = $user_solds;

                // $arr[array_keys($user_solds)[0]] = $user_solds[array_keys($user_solds)[0]];
            }

        }
        $user_sold = $arr;
        

        // return $arr;
        $regions = DB::table('tg_region')->get();
        $shablons = DB::table('tg_shablons')->get();
        // return $pusers;

        return view('pharmacy.index',compact('shablons','regions','pharmacy','users','pusers','farm_sold','user_sold','dateText'));
    }

    public function pharmacyUsers($time)
    {
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }
        $pharmacy = Region::with('pharmacy')->get();
        $pusers = PharmacyUser::select('tg_user.id','tg_user.first_name','tg_user.last_name','tg_pharmacy_users.*')
        ->join('tg_user','tg_user.id','tg_pharmacy_users.user_id')
        ->get();
        $users = DB::table('tg_user')->where('rm',0)->whereIn('status',[0,1])->get();

        $farm_sold = DB::table('tg_productssold')
        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.pharm_id')
        ->whereDate('tg_productssold.created_at','>=',$date_begin)
        ->whereDate('tg_productssold.created_at','<=',$date_end)
        ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
        ->groupBy('tg_productssold.pharm_id')->pluck('allprice','tg_productssold.pharm_id');

        $pharmacy_id = Pharmacy::pluck('id')->toArray();

        $arr = [];
        // $user_solds = DB::table('tg_productssold')
        //     ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.user_id')
        //     ->whereDate('tg_productssold.created_at','>=',$date_begin)
        //     ->whereDate('tg_productssold.created_at','<=',$date_end)
        //     ->join('tg_user','tg_user.id','tg_productssold.user_id')
        //     ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
        //     ->groupBy('tg_productssold.user_id')->pluck('allprice','tg_productssold.user_id')->toArray();
        //     return $user_solds;
        foreach ($pharmacy_id as $key => $value) {
            $user_solds = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_productssold.user_id')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_productssold.pharm_id','=',$value)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
            ->groupBy('tg_productssold.user_id')->pluck('allprice','tg_productssold.user_id')->toArray();
            if(count($user_solds) != 0)
            {

                // foreach ($user_solds as $key => $value) {
                //     $arr[$key] = $value;
                // }
                $arr[$value] = $user_solds;

                // $arr[array_keys($user_solds)[0]] = $user_solds[array_keys($user_solds)[0]];
            }

        }
        $user_sold = $arr;
        

        // return $arr;
        $regions = DB::table('tg_region')->get();
        $shablons = DB::table('tg_shablons')->get();
        // return $pusers;
        dd($shablons,$regions,$pharmacy,$users,$pusers,$farm_sold,$user_sold,$dateText);

        return view('pharmacy.index',compact('shablons','regions','pharmacy','users','pusers','farm_sold','user_sold','dateText'));
    }

    public function delete($id)
    {
        return $id;

        // FirewallSold::where('pharmacy_id',$id);

        // $mcid = McOrder::where('pharmacy_id',$id)->pluck('id')->toArray();
        // McOrder::whereIn('id',$mcid);
        // McOrderDetail::whereIn('order_id',$mcid)->delete();
        // McOrderDelivery::whereIn('order_id',$mcid)->delete();
        // McPaymentHistory::whereIn('order_id',$mcid)->delete();
    }
}
