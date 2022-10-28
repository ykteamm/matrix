<?php

namespace App\Services;

use App\Items\ElchilarKunlikItems;
use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\ProductSold;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ElchilarService
{
    public function elchilar()
    {
        $userarrayreg = [];
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $users = DB::table('tg_user')
                ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();
            foreach ($users as $key => $value) {
                $userarrayreg[] = $value->id;
            }
        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
                    $r_id_array[] = $key;
                }
            }
            $users = DB::table('tg_user')
                ->whereIn('tg_region.id',$r_id_array)
                ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();
            foreach ($users as $key => $value) {
                $userarrayreg[] = $value->id;
            }

        }

        $elchi = DB::table('tg_user')
            ->whereIn('tg_user.id',$userarrayreg)
            ->where('tg_user.admin',FALSE)
            ->select('tg_user.pharmacy_id','tg_user.image_url','tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('tg_user.admin','DESC')->get();

        $elchi_work=[];
        $elchi_fact=[];
        $elchi_prognoz=[];
        $cale = DB::table('tg_calendar')->where('year_month',today()->format('m.Y'))->first();
        $cale_date = json_decode($cale->day_json);
        // return $elchi;
        $date = DB::table('tg_smena')
            // ->whereIn(DB::raw('DATE(created_from)'), $all_date)
            ->whereDate('created_from','>=',today()->format('Y-m').'-01')
            ->whereDate('created_from','<=',today()->format('Y-m').'-30')
            ->where('smena',2)
            ->where('user_id', 35)
            ->orderBy('created_from','DESC')
            ->pluck('created_from');
        // return $date[0];
        $fsd=[];
        foreach($elchi as $elch)
        {

            $date = DB::table('tg_smena')
                // ->whereIn(DB::raw('DATE(created_from)'), $all_date)
                ->whereDate('created_from','>=',today()->format('Y-m').'-01')
                ->whereDate('created_from','<=',today()->format('Y-m').'-30')
                ->where('smena',2)
                ->where('user_id', $elch->id)
                ->orderBy('created_from','DESC')
                ->pluck('created_from');

            // return $date;
            // $fsd[]=$date;
            if(isset($date[0]))
            {


                $all_date=[];
                foreach($cale_date as $key => $value)
                {
                    if($value == 'true' && $key <=  date('d',(strtotime ( $date[0] ) )))
                    {
                        if (strlen($key) == 1) {
                            $key = '0'.$key;
                        }
                        $all_date[] = today()->format('Y-m').'-'.$key;
                    }
                }
                $no_day=0;
                foreach($date as $item){
                    if(!in_array($item,$all_date)){
                        $no_day += 1;
                    }
                }
                $sunday = 0;
                foreach($date as $d)
                {
                    if(date('l',(strtotime ( $d ) )) == 'Sunday')
                    {
                        $sunday = $sunday + 1;

                    }
                }


                $pr = count($all_date)+$sunday;
                // return $date;
                $elchi_work[$elch->id] = ($cale->work_day+$sunday).'/'.(count($date)).'/'.$pr;

                $user = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_medicine.price) as allprice,SUM(tg_productssold.number) as allnumber,tg_medicine.name,tg_medicine.price')
                    ->whereIn(DB::raw('DATE(tg_productssold.created_at)'), $date)
                    ->where('tg_user.id', $elch->id)
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->groupBy('tg_medicine.name','tg_medicine.price')->get();
                $user_sum=0;
                foreach($user as $key)
                {
                    $user_sum += $key->allprice;
                }
                if(count($date) == 0)
                {
                    $prognoz = 0;

                }else{

                    if($pr == 0)
                    {
                        $prognoz = 0;
                    }else{
                        $prognoz = number_format(($user_sum/$pr)*($cale->work_day+$sunday),0,'','.');

                    }
                }
                $elchi_fact[$elch->id] = number_format($user_sum, 0, '', '.');

                $elchi_prognoz[$elch->id] = $prognoz;
                $user_sum=0;
            }else{
                $elchi_prognoz[$elch->id] = 0;
                $elchi_fact[$elch->id] = 0;
                $elchi_work[$elch->id] = 0;

            }
        }
        $data=new ElchilarKunlikItems();
        $data->elchi=$elchi;
        $data->elchi_fact=$elchi_fact;
        $data->elchi_work=$elchi_work;
        $data->elchi_prognoz=$elchi_prognoz;





     return $data;
    }

    public function plan($elchi)
    {
        $plan_sum=[];
        $i=0;
        foreach ($elchi as $item){
            $plan_sum[$i]=0;
            $plans=Plan::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            foreach ($plans as $plan){
                $narx=DB::table('tg_medicine')
                    ->select('tg_medicine.price')
                    ->where('id',$plan->medicine_id)->first();
                $plan_sum[$i]+=$plan->number*$narx->price;
            }
            $i++;
        }
//        dd($plan_sum);
        return $plan_sum;
    }

    public function planday($elchi)
    {
        $plan_sum=[];
        $cal=Calendar:: select('work_day')->where('year_month',date('m.Y'))->first();
//        dd($cal->work_day);
        $i=0;
        foreach ($elchi as $item){
            $plan_sum[$i]=0;
            $plans=Plan::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            foreach ($plans as $plan){
                $narx=DB::table('tg_medicine')
                    ->select('tg_medicine.price')
                    ->where('id',$plan->medicine_id)->first();
                $plan_sum[$i]+=$plan->number*$narx->price/$cal->work_day;
            }
            $i++;
        }
        return $plan_sum;
    }

    public function encane($elchi)
    {
        $encane=[];
        $t=0;
        $apteka=DB::table('tg_pharmacy')->get();
//        dd($apteka);
        foreach ($elchi as $item){
            $encane[$t]='nomalum';
            foreach ($apteka as $apt){
                if ($item->pharmacy_id==$apt->id){
                    $encane[$t]=$apt->name;
                }
            }
                $t++;
        }
        return $encane;
    }

    public function checkCalendar()
    {
        $startOfMonth=date('d.m.Y',strtotime(Carbon::now()->startOfMonth()));
        $today=date('d.m.Y',strtotime(Carbon::now()));
        $difference=date('d',strtotime($today)) - date('d',strtotime($startOfMonth))+1;
        for($i=0;$i<$difference;$i++){
            $d=$i.' day';
            $days[$i]=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
        }


        return $days;
    }

    public function sold($elchi,$days)
    {
        $sold=[];
        $i=0;
        foreach ($elchi as $item){
            $MonthSold=ProductSold::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
            $j=0;
            foreach ($days as $day){
                $sold[$i][$j]=0;
                foreach ($MonthSold as $daysold){
                    if(date('d',strtotime($daysold->created_at))==date('d',strtotime($day))){
                        $sold[$i][$j]+=$daysold->price_product*$daysold->number;
                    }
                }
                $j++;
            }
            $i++;
        }
        return $sold;
    }

}
