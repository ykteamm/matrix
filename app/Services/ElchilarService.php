<?php

namespace App\Services;

use App\Items\ElchilarKunlikItems;
use App\Items\ElchiTimeItems;
use App\Models\Calendar;
use App\Models\DailyWork;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\ProductSold;
use App\Models\Region;
use App\Models\User;
use App\Models\Member;
use App\Models\Team;
use App\Models\PharmacyUser;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ElchilarService
{
    public function elchilar($month,$endofmonth,$user_id,$regions, $all_or_new, $climate)
    {
        $positions=DB::table('tg_positions')
            ->selectRaw('tg_positions.position_json')
            ->where('tg_user.id',$user_id)
            ->join('tg_user','tg_user.rol_id','tg_positions.id')
            ->first();
        $pos=json_decode($positions->position_json);

        // $get_work_user = User::where('status',1)->pluck('id')->toArray();

        $yes_user_id = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                    ->where('tg_user.rm','!=',1)
                    ->whereDate('tg_productssold.created_at','>=',date('Y-m',strtotime($month)).'-01')
                    ->whereDate('tg_productssold.created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->groupBy('tg_user.id')->pluck('id')->toArray();
        // $yes_user_id = array_unique(array_merge($get_work_user,$sold_work_user));

        // dd($sold_work_user);
        if(isset($pos->region)){
            if($regions == 0 || $regions == 1)
            {
                $elchi = User::with('pharmacy')
                ->select('tg_user.specialty_id as sid','tg_user.date_joined','tg_user.work_start','tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id');

                if($all_or_new == 'new') {
                    $elchi = $elchi->where('tg_user.status', 0)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);
                }elseif($all_or_new == 'elchi')
                {
                    $elchi = $elchi->where('tg_user.status', 1)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);

                }
                elseif($all_or_new == 'pro')
                {
                    $elchi = $elchi->where('tg_user.specialty_id', 9);
                }
                elseif($all_or_new == 'elchi_all')
                {
                    $elchi = $elchi->whereIn('tg_user.status', [0,1])->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);
                }
                else {
                    $elchi = $elchi
                    ->whereIn('tg_user.id',$yes_user_id);
                }

                if($climate == 'west') {
                    $elchi = $elchi->where('tg_region.side', 1);
                } else if ($climate == 'east'){
                    $elchi = $elchi->where('tg_region.side', 2);
                }
                $elchi = $elchi->orderBy('tg_region.side','ASC')->get();

            }else
            {
                $elchi = User::with('pharmacy')
                ->whereIn('tg_region.id',$regions)
                ->select('tg_user.specialty_id as sid','tg_user.date_joined','tg_user.work_start','tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')

                // ->select('tg_new_elchi.created_at as new_created','tg_user.date_joined','tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id');

                if($all_or_new == 'new') {
                    $elchi = $elchi->where('tg_user.status', 0)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);
                }elseif($all_or_new == 'elchi')
                {
                    $elchi = $elchi->where('tg_user.status', 1)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);

                }
                elseif($all_or_new == 'pro')
                {
                    $elchi = $elchi->where('tg_user.specialty_id', 9);
                }elseif($all_or_new == 'elchi_all')
                {
                    $elchi = $elchi->whereIn('tg_user.status', [0,1])->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);
                }
                else {
                    $elchi = $elchi
                    ->whereIn('tg_user.id',$yes_user_id);
                }

                if($climate == 'west') {
                    $elchi = $elchi->where('tg_region.side', 1);
                } else if ($climate == 'east'){
                    $elchi = $elchi->where('tg_region.side', 2);
                }
                $elchi = $elchi->orderBy('tg_region.side','ASC')->get();
            }

        }
        else{
            $reg=[];
            foreach ($pos as $key=>$val){
                if($key==1||
                    $key==2||
                    $key==3||
                    $key==4||
                    $key==5||
                    $key==6||
                    $key==7||
                    $key==8||
                    $key==9||
                    $key==10||
                    $key==11||
                    $key==12||
                    $key==13||
                    $key==14 )
                $reg[]=$key;
            }
            $elchi = User::with('pharmacy')
                // ->where('tg_user.status',1)
                // ->whereIn('tg_user.id',$yes_user_id)
                ->whereIn('tg_user.region_id',$reg)
                ->select('tg_user.specialty_id as sid','tg_user.date_joined','tg_user.work_start','tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')

                // ->select('tg_user.date_joined','tg_user.start_work','tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id');
                // ->orderBy('tg_region.side','ASC')->get();

                if($all_or_new == 'new') {
                    $elchi = $elchi->where('tg_user.status', 0)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);
                }elseif($all_or_new == 'elchi')
                {
                    $elchi = $elchi->where('tg_user.status', 1)->where('tg_user.specialty_id', 1)
                    ->where('tg_user.rm','!=',1);

                }
                elseif($all_or_new == 'pro')
                {
                    $elchi = $elchi->where('tg_user.specialty_id', 9);
                }
                else {
                    $elchi = $elchi
                    ->whereIn('tg_user.id',$yes_user_id);
                }
                if($climate == 'west') {
                    $elchi = $elchi->where('tg_region.side', 1);
                } else if ($climate == 'east'){
                    $elchi = $elchi->where('tg_region.side', 2);
                }
                $elchi = $elchi->orderBy('tg_region.side','ASC')->get();
        }

        $dd = [];


        foreach ($elchi as $key => $value) {
            $s=DB::table('tg_productssold')
                ->where('user_id',$value->id)
                ->selectRaw('SUM(tg_productssold.number*tg_productssold.price_product) as all_price,user_id')
                ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->groupBy('user_id')
                ->first();

            if($s != null)
            {
                if($s->all_price > 0)
                {
                    $dd[] = $value;
                }
            }
        }
        
        $elchi = $dd;

        $elchi_work=[];

        $elchi_prognoz=[];
        $cale_date=[];
        $all_work_day=[];
        $work_d=[];
        $king_sold=[];
        $king_sold_month=[];
        $best_month = [];
        $all_best_month = 0;
        $cale = DB::table('tg_calendar')->where('year_month',date('m.Y',strtotime($month)))->first();
        $cale_d = json_decode($cale->day_json);
        foreach($cale_d as $key => $c)
        {
            $cale_date[$key+1]=$c;
            if($c == 'true')
            {
                $all_work_day[]=$key+1;
            }
        }

        $old_month = date('Y-m',strtotime($month.'-01'));
        $now_month = date('Y-m',strtotime(date_now()));
        $begin_date = intval(date('d',strtotime($month.'-01')));
        $end_date = intval(date('d',strtotime($month.'-'.$endofmonth)));
        $remain=0;
        // dd($now_month);

        if($old_month != $now_month)
        {
            for ($i=$begin_date; $i <= $end_date; $i++) {
                if(in_array($i,$all_work_day))
                {
                    $remain +=1;
                }
            }
        }else{
        $end_date = intval(date('d',strtotime(date_now())));

            for ($i=$begin_date; $i < $end_date; $i++) {
                if(in_array($i,$all_work_day))
                {
                    $remain +=1;
                }
            }
        }

        // dd($elchi);
        foreach($elchi as $elch)
        {
            $date = DB::table('tg_shift')
                ->whereDate('open_date','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('open_date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->where('active',2)
                ->where('user_id',$elch->id)
                ->orderBy('open_date','DESC')
                ->pluck('open_date');
            // dd($date);

            $day_work_array=[];
            foreach($date as $key => $c)
                {
                    $day_work_array[] = intval(date('d',strtotime($c)));
                }

                $sunday = 0;
                foreach($date as $d)
                {
                    if(date('l',(strtotime ( $d ) )) == 'Sunday')
                    {
                        $sunday = $sunday + 1;

                    }
                }

                $month_sol = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                ->whereDate('tg_productssold.created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('tg_productssold.created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->where('tg_productssold.user_id',$elch->id)
                ->get()[0]->allprice;

                if($month_sol == NULL)
                {
                    $month_sol = 0;
                    $prog = 0;

                }else{
                    $use = [];
                    if(date('d') == 1)
                    {
                        $st = 1;
                    }else{
                        $st = date('d')-1;
                    }
                    // $en = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->lastOfMonth()->format('d');

                    $prog = floor(($month_sol*$endofmonth)/$st);

                    // $prog = ($month_sol*30)/14;
                }
                // $user = DB::table('tg_productssold')
                //     ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                //     ->whereIn(DB::raw('DATE(tg_productssold.created_at)'), $date)
                //     ->where('tg_user.id','=',$elch->id)
                //     ->join('tg_user','tg_user.id','tg_productssold.user_id')
                //     ->groupBy('tg_user.id')->first();

                // if(isset($user->allprice))
                // {
                    // if(count($date) == 0)
                    // {
                    //     $prog = 0;
                    // }else{
                    //     $prog = (count($all_work_day)/$remain)*$user->allprice;
                    // }
                // }else{
                //     $prog = 0;
                // }

                $king_soldis = DB::table('tg_king_sold')
                    ->selectRaw('count(tg_king_sold.id) as count')
                    ->where('tg_king_sold.admin_check',1)
                    ->where('tg_user.id',$elch->id)
                    ->whereDate('tg_king_sold.created_at','=',date('Y-m-d'))
                    ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                    ->join('tg_user','tg_user.id','tg_order.user_id')
                    ->get();
                $king_sold[$elch->id] = $king_soldis[0]->count;

                $king_soldis_month = DB::table('tg_king_sold')
                ->selectRaw('count(tg_king_sold.id) as count')
                ->where('tg_king_sold.admin_check',1)
                ->where('tg_user.id',$elch->id)
                ->whereDate('tg_king_sold.created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('tg_king_sold.created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                ->join('tg_user','tg_user.id','tg_order.user_id')
                ->get();

                $king_sold_month[$elch->id] = $king_soldis_month[0]->count;

                $mustang = $this->bestMonthSold();

                $best_month[$elch->id] = $this->bestRegion($mustang,$elch->id);

                if(isset($best_month[$elch->id][0]['bestsumText']))
                {
                    $all_best_month = $all_best_month + $best_month[$elch->id][0]['bestsumText'];
                }

               


                $proggg = myPrognoz($elch->id);
                $elchi_prognoz[$elch->id] = $proggg;


                $shift = DB::table('tg_shift')
                ->where('tg_shift.open_date','!=',null)
                ->where('tg_shift.user_id',$elch->id)
                ->where('tg_shift.pharma_id','!=',42)
                ->whereDate('tg_shift.open_date','>=',$month.'-01')
                ->whereDate('tg_shift.open_date','<',$month.'-'.$endofmonth)
                ->count();

                $shift2 = DB::table('tg_smena')
                ->selectRaw('count(tg_smena.id) as count')
                ->where('tg_smena.smena',2)
                ->where('tg_smena.user_id',$elch->id)
                ->whereDate('tg_smena.created_at','>=',$month.'-01')
                ->whereDate('tg_smena.created_at','<',$month.'-'.$endofmonth)
                ->get()[0]->count;

                $work_d[$elch->id] = $shift+$shift2;
                // dd($endofmonth);



        }
        // dd($elchi_prognoz);

        $fact=[];
        $i=0;
        $average=[];

        // dd($elchi);
        foreach ($elchi as $item){

            $s=DB::table('tg_productssold')
                ->where('user_id',$item->id)
                ->selectRaw('SUM(tg_productssold.number*tg_productssold.price_product) as all_price,user_id')
                ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->groupBy('user_id')
                ->first();

                $shift = $work_d[$item->id];



            if(isset($s->all_price)){
                $fact[$item->id]=$s->all_price;
                if($shift == 0)
                {
                    $average[$item->id]=0;

                }else{
                    $average[$item->id]=round($s->all_price/$shift);

                }

            }
            else{
                $fact[$item->id]=0;
                $average[$item->id]=0;
            }
            $i++;
        }
        // dd($fact);
        $data=new ElchilarKunlikItems();
        $data->elchi=$elchi;
        $data->all_work_day=$work_d;
        $data->elchi_fact=$fact;
        $data->average=$average;
        $data->elchi_prognoz=$elchi_prognoz;
        $data->king_sold=$king_sold;
        $data->king_sold_month=$king_sold_month;
        $data->best_month=$best_month;
        $data->all_best_month=$all_best_month;
     return $data;
    }
    public function capitan($month,$endofmonth,$user_id)
    {
        $cap = Member::where('user_id',Session::get('user')->id)->first();
        $team = Member::where('team_id',$cap->team_id)->pluck('user_id');

        $elchi = DB::table('tg_user')
                ->where('tg_user.status',1)
                ->whereIn('tg_user.id',$team)
                ->select('tg_user.pharmacy_id','tg_region.side as side','tg_user.image_url','tg_user.status','tg_region.id as rid','tg_region.name as v_name','tg_region.id as v_id','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->orderBy('tg_region.side','ASC')->get();

        $elchi_work=[];

        $elchi_prognoz=[];
        $cale = DB::table('tg_calendar')->where('year_month',date('m.Y',strtotime($month)))->first();
        $cale_date = json_decode($cale->day_json);

        foreach($elchi as $elch)
        {
            $date = DB::table('tg_smena')
                ->whereDate('created_from','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_from','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->where('smena',2)
                ->where('user_id', $elch->id)
                ->orderBy('created_from','DESC')
                ->pluck('created_from');
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
                        $all_date[] = date('Y-m',strtotime($month)).'-'.$key;
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
                $elchi_work[$elch->id] = ($cale->work_day+$sunday).'/'.(count($date)).'/'.$pr;

                $user = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,SUM(tg_productssold.number) as allnumber,tg_medicine.name,tg_productssold.price_product')
                    ->whereIn(DB::raw('DATE(tg_productssold.created_at)'), $date)
                    ->where('tg_user.id', $elch->id)
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->groupBy('tg_medicine.name','tg_productssold.price_product')->get();
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

                $elchi_prognoz[$elch->id] = $prognoz;
                $user_sum=0;
            }else{
                $elchi_prognoz[$elch->id] = 0;
                $elchi_fact[$elch->id] = 0;
                $elchi_work[$elch->id] = 0;

            }
        }
        $fact=[];
        $i=0;
        foreach ($elchi as $item){

            $s=DB::table('tg_productssold')
                ->where('user_id',$item->id)
                ->selectRaw('SUM(tg_productssold.number*tg_productssold.price_product) as all_price,user_id')
                ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->groupBy('user_id')
                ->first();
            if(isset($s->all_price)){
                $fact[$item->id]=$s->all_price;

            }
            else{
                $fact[$item->id]=0;
            }
            $i++;
        }

        $data=new ElchilarKunlikItems();
        $data->elchi=$elchi;
        $data->elchi_fact=$fact;
        $data->elchi_prognoz=$elchi_prognoz;
     return $data;
    }

    public function plan($elchi,$month,$endofmonth)
    {
        $planday=[];
        $i=0;
        $cal=Calendar:: select('work_day')->where('year_month',date('m.Y',strtotime($month)))->first();
        foreach ($elchi as $item){
            // $plan_sum[$i]=0;
            // $plans=Plan::where('user_id',$item->id)
            //     ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
            //     ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)->get();
            // foreach ($plans as $plan){
            //     $narx=DB::table('tg_prices')
            //         ->select('tg_prices.price')
            //         ->where('tg_prices.shablon_id',$plan->shablon_id)
            //         ->where('tg_prices.medicine_id',$plan->medicine_id)->first();
            //     if(isset($narx->price)){
            //         $plan_sum[$i]+=$plan->number*$narx->price;
            //     }
            // }
            // $planday[$i]=$plan_sum[$i]/$cal->work_day$cal->work_day;

            $plans=DB::table('user_plans')->where('user_id',$item->id)
                ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)->get();
            if(count($plans) > 0)
            {
                $plan_sum[$item->id] = $plans[0]->plan;
                $planday[$item->id] = $plan_sum[$item->id]/$cal->work_day;
            }else{
                $plan_sum[$item->id] = 0;
                $planday[$item->id] = 0;
            }

            // $i++;

        }
        $item=new ElchiTimeItems();
        $item->plan=$plan_sum;
        $item->planday=$planday;
        return $item;
    }

//
//    public function planday($elchi,$month,$endofmonth)
//    {
//        $plan_sum=[];
//        $cal=Calendar:: select('work_day')->where('year_month',date('m.Y',strtotime($month)))->first();
////        dd($cal);
//        $i=0;
//        foreach ($elchi as $item){
//            $plan_sum[$i]=0;
//            $plans=Plan::where('user_id',$item->id)
//                ->whereDate('created_at','>=', date('Y-m',strtotime($month)).'-01')
//                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)->get();
//            foreach ($plans as $plan){
//                $narx=DB::table('tg_medicine')
//                    ->select('tg_medicine.price')
//                    ->where('id',$plan->medicine_id)->first();
//                $plan_sum[$i]+=$plan->number*$narx->price/$cal->work_day;
//            }
//            $i++;
//        }
//        return $plan_sum;
//    }

    public function encane($elchi, $month)
    {
        $start = Carbon::parse($month)->startOfMonth()->format("Y-m-d");
        $end = Carbon::parse($month)->endOfMonth()->format("Y-m-d");

        $encane=[];
        foreach ($elchi as $item){
                        $sum = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
                        ->where('tg_productssold.user_id','=', $item->id)
                        ->whereBetween('tg_productssold.created_at', [$start, $end])
                        ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
                        ->orderBy('allprice','DESC')
                        ->groupBy('tg_pharmacy.id')->get();
                        $encane[$item->id]=$sum;
        }
        return $encane;
    }

    public function checkCalendar($month,$endofmonth)
    {
        if(date('m',strtotime($month))==date('m')){
            $startOfMonth = date('d.m.Y', strtotime(date('Y-m', strtotime($month)) . '-01'));
            $today = date('d.m.Y', strtotime(Carbon::now()));
            $difference = date('d', strtotime($today)) - date('d', strtotime($startOfMonth)) + 1;
            for ($i = 0; $i < $difference; $i++) {
                $d = $i . ' day';
                $days[$i] = date("Y-m-d", strtotime($d, strtotime(date('Y-m', strtotime($month)) . '-01')));
            }

        }
        else {
            for ($i = 0; $i < $endofmonth; $i++) {
                $d = $i . ' day';
                $days[$i] = date("Y-m-d", strtotime($d, strtotime(date('Y-m', strtotime($month)) . '-01')));
            }
        }


        return $days;
    }
//
//    public function mysold($elchi,$days,$month,$endofmonth)
//    {
//        $sold=[];
//        $i=0;
//        foreach ($elchi as $item){
//            $MonthSold=ProductSold::where('user_id',$item->id)
//                ->whereDate('created_at','>=', date('Y-m',strtotime($month)).'-01')
//                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)->get();
//            $j=0;
//            foreach ($days as $day){
//                $sold[$i][$j]=0;
//                foreach ($MonthSold as $daysold){
//                    if(date('d',strtotime($daysold->created_at))==date('d',strtotime($day))){
//                        $sold[$i][$j]+=$daysold->price_product*$daysold->number;
//                    }
//                }
//                $j++;
//            }
//            $i++;
//        }
//        return $sold;
//    }
    public function sold($elchi,$days)
    {
        $sold=[];
        $sold2=[];
        foreach ($elchi as $key => $item){
            foreach ($days as $keys => $day) {
                // $daily = DailyWork::where('active', 1)->where('user_id', $item->id)->first();
                try {
                    $smena = Shift::whereDate('created_at', $day)->where('user_id', $item->id)->first();
                    $time = strtotime($smena->close_date) - strtotime($smena->open_date);
                    $hour = (int)round($time/3600, 0);
                    $minute = (int)round(($time%3600)/60, 0);
                    if($hour > 5) {
                        $hour -= 1;
                    }
                } catch (\Throwable $th) {
                    $hour = 0;
                    $minute = 0;
                }
                $smena = Shift::whereDate('created_at', $day)->where('user_id', $item->id)->first();
                if($smena)
                {
                    $open = $smena->open_date;
                    $close = $smena->close_date;
                }else{
                    $open = 0;
                    $close = 0;
                }
                $MonthSold=ProductSold::where('user_id',$item->id)
                    ->whereDate('created_at','=', $day)->sum(DB::raw('price_product*number'));

                $user = User::find($item->id);

                if($user->date_joined > '2023-08-01')
                {
                    if($user->work_start > $day)
                    {
                        $sold2[$keys]= ['sold'=>$MonthSold, 'hour' => $hour, 'minute'=>$minute,'open' => 1111,'close' => $close,'day' => $day];
    
                    }elseif($user->work_start == null)
                    {
                        $sold2[$keys]= ['sold'=>$MonthSold, 'hour' => $hour, 'minute'=>$minute,'open' => 1111,'close' => $close,'day' => $day];
                    }
                    else{
                        $sold2[$keys]= ['sold'=>$MonthSold, 'hour' => $hour, 'minute'=>$minute,'open' => $open,'close' => $close,'day' => $day];
    
                    }
                }else{
                    $sold2[$keys]= ['sold'=>$MonthSold, 'hour' => $hour, 'minute'=>$minute,'open' => $open,'close' => $close,'day' => $day];
                }
                

            }
            $sold[$item->id]=$sold2;
        }
        return $sold;
    }
    public function reyting($elchi)
    {
        $yulduz = DB::table('tg_question')->where('grade',6)->first();
        $department = DB::table('tg_department')->where('status',1)->get();

        $users = DB::table('tg_grade')
            ->select('tg_user.id','tg_user.first_name','tg_user.last_name')
            ->where('tg_grade.question_id','!=',$yulduz->id)
            ->join('tg_user','tg_user.id','tg_grade.teacher_id')
            ->distinct()
            ->get();
        $elchilar=[];
        foreach ($elchi as $item){





            $id=$item->id;

            $d_array =[];
            $d_for_user = [];
            $d_for_user2 = [];
            $allquestion = [];
            $allavg = 0;



            foreach($department as $depar)
            {
                $question = DB::table('tg_question')->where('department_id',$depar->id)->get();


                foreach($users as $dnam)
                {
                    $quescount = 0;
                    $avg_u = 0;
                    $avg_q = 0;
                    $ads = [];

                    foreach($question as $key => $ques)
                    {
                        $grade = DB::table('tg_grade')
                            ->where('teacher_id',$dnam->id)
                            ->where('user_id',$id)
                            ->where('question_id',$ques->id)
                            ->avg('grade');

                        $quesforuser = DB::table('tg_grade')
                            ->select('tg_department.id as did','tg_question.name as qname','tg_grade.*')
                            ->where('teacher_id',$dnam->id)
                            ->where('user_id',$id)
                            ->where('question_id',$ques->id)
                            ->join('tg_question','tg_question.id','tg_grade.question_id')
                            ->join('tg_department','tg_department.id','tg_question.department_id')
                            ->get();
                        foreach($quesforuser as $keyd => $valued)
                        {
                            $allquestion[] = $valued;
                        }
                        if($grade != NULL)
                        {
                            $quescount++;

                        }
                        $avg_q += $grade;

                    }
                    if($quescount == 0)
                    {
                        $avg_u += 0;

                    }else{
                        $avg_u += $avg_q/$quescount;

                    }

                    if($avg_u > 0)
                    {
                        $d_for_user[] = array('uid' => $dnam->id,'avg' => number_format($avg_u,2),'depid' => $depar->id,'username' => $dnam->last_name.' '.$dnam->first_name);
                        $d_for_user2[] = array('avg' => number_format($avg_u,2),'depid' => $depar->id,'username' => $dnam->last_name.' '.$dnam->first_name);
                    }
                    // $avg_q = 0;
                    // $avg_u = 0;
                    // $quescount = 0;


                }
                $avguser = 0;
                foreach($d_for_user2 as $keyr => $valuer)
                {
                    $avguser += $valuer['avg'];
                }
                if(count($d_for_user2) == 0)
                {
                    $allsavguser = 0;

                }else{
                    $allsavguser = $avguser/count($d_for_user2);
                    $ads[] = $allsavguser;
                }
                // $d_array[] = array('id'=>$depar->id,'name' => $depar->name,'avg' => $avguser);
                // $avguser = 0;

                $d_array[] = array('id'=>$depar->id,'name' => $depar->name,'avg' => number_format($allsavguser, 2));
                $d_for_user2 = [];



            }
            $davg = 0;
            $maxnol = 0;
            foreach($d_array as $dr)
            {
                if($dr['avg'] > 0)
                {
                    $maxnol +=1;
                }
                $davg += $dr['avg'];
            }
            if($maxnol == 0)
            {
                $allavg =0;
            }else{


                $allavg = $davg/$maxnol;
            }


            $client = DB::table('tg_cgrade')->where('question_id',$yulduz->id)
                ->where('user_id',$id)->distinct()->pluck('teacher_id');
            // return $client;


            $tashqi = DB::table('tg_cgrade')->where('question_id',$yulduz->id)
                ->where('user_id',$id)
                ->get();
            // return $tashqi;
            $tgrade=0;
            $altgarde=0;
            foreach($client as $cl)
            {
                if(count($tashqi) != 0)
                {


                    foreach($tashqi as $tq)
                    {
                        if($cl == $tq->teacher_id)
                        {
                            $tgrade += $tq->grade;
                        }
                    }

                    $altgarde += $tgrade/count($tashqi);

                }else{
                    $altgarde += 0;

                }

            }

            if(count($client) == 0)
            {
                $altgardes = 0.00;
            }else{

                // return $allquestion;
                $altgardes = number_format($altgarde/count($client),2);
            }

            $knowledges = DB::table('tg_knowledge')->whereIn('step',[1,3])->get();
            $know_teachers = DB::table('tg_knowledge_grades')->distinct()->pluck('teacher_id');
            // return $know_teachers;
            $pill_array = [];
            $step_array = [];
            $step_array_counter = [];
            $step_array_grade_all = [];

            foreach($knowledges as $knowledge)
            {
                if($knowledge->step == 1){
                    $pill_counter = 0;
                    foreach($know_teachers as $teachers)
                    {
                        $condition = DB::table('tg_pill_questions')->where('knowledge_id',$knowledge->id)->pluck('id');
                        $questions = DB::table('tg_knowledge_grades')
                            ->whereIn('pill_id',$condition)
                            ->where('user_id',$id)
                            ->where('teacher_id',$teachers)->avg('grade');

                        $questions_grade = DB::table('tg_knowledge_grades')
                            ->whereIn('pill_id',$condition)
                            ->where('user_id',$id)
                            ->where('teacher_id',$teachers)->first();

                        $step_array_grade_all[] = $questions_grade;

                        $questions_count = DB::table('tg_knowledge_grades')
                            ->whereIn('pill_id',$condition)
                            ->where('user_id',$id)
                            ->where('teacher_id',$teachers)->count();

                        $step_array_grade = [];

                        if($questions == 0 )
                        {
                            $pill_avg = 0;

                        }else{
                            $pill_avg = $questions/$questions_count;
                        }

                        $pill_counter += $pill_avg;
                    }
                    if($pill_counter == 0)
                    {
                        $all_avg = 0;
                    }else{
                        $all_avg = $pill_counter/count($know_teachers);
                    }
                    $pill_array[] = array('avg' => number_format($all_avg,2),'name' =>$knowledge->name);
                }
                if($knowledge->step == 3){

                    $condition_step = DB::table('tg_pill_questions')->where('knowledge_id',$knowledge->id)->get();

                    foreach($condition_step as $key_con => $con)
                    {
                        $pill_counter = 0;
                        $pill_counter_count = 0;

                        foreach($know_teachers as $teachers)
                        {

                            $step3 = DB::table('tg_knowledge_grades')
                                ->select('tg_knowledge_grades.grade','tg_pill_questions.name','tg_pill_questions.id as pid')
                                ->where('tg_knowledge_grades.teacher_id',$teachers)
                                ->where('tg_pill_questions.id',$con->id)
                                ->where('tg_knowledge_grades.user_id',$id)
                                ->join('tg_knowledge_questions','tg_knowledge_questions.id','tg_knowledge_grades.knowledge_question_id')
                                ->join('tg_condition_questions','tg_condition_questions.id','tg_knowledge_questions.condition_question_id')
                                ->join('tg_pill_questions','tg_pill_questions.id','tg_condition_questions.pill_question_id')
                                ->avg('tg_knowledge_grades.grade');
                            if($step3 != 0)
                            {
                                if(isset($step_array_counter[$key_con]))
                                {
                                    $step_array_counter[$key_con] = $step_array_counter[$key_con] + 1;
                                    $step_array[$key_con] = array('count' => $step_array[$key_con]['count'] + 1,'id' => $key_con,'avg' => $step_array[$key_con]['avg'] + $step3,'name' => $con->name);

                                }else{
                                    $step_array_counter[$key_con] = 1;
                                    $step_array[$key_con] = array('count' => 1,'avg' => $step3,'name' => $con->name);

                                }
                            }
                        }

                    }


                }


            }


            $i = 0;
            $avgs = 0;
            foreach ($pill_array as $key => $item1)
            {$i++;
                $avgs += $item1['avg'];}
            // @endforeach
            foreach ($step_array as $key => $item1)
            { $i++;
                if($item1['count'] == 0)
                {
                    $avgs += 0;
                }else{
                    $avgs += $item1['avg']/$item1['count'];
                }

            }
            if($i == 0)
            {
                $all_avgs = 0;
            }else{
                $all_avgs = number_format($avgs/$i,2);

            }

            if($all_avgs != 0)
            {
                if($allavg == 0)
                {
                    $allavg = $all_avgs;
                }else{
                    $allavg = ($allavg + $all_avgs)/2;

                }
            }





            $elchilar[]=array('elchi'=>$item,'ichki-reyting'=>$allavg,'tashqi-reyting'=>$altgardes);
        }

        return $elchilar;
    }

    public function haftalik($days,$sold,$elchi)
    {
        $i=0;
        $arr=[];
        foreach ($elchi as $el){
            $j=0;
            $s=0;
            foreach ($days as $day){
                if($j==0||$j==7||$j==14||$j==21){
                    $arr[$el->id][$s]=0;
                }
                $arr[$el->id][$s]+=$sold[$el->id][$j]['sold'];
                if($j==6||$j==13||$j==20){
                    $s++;
                }
                $j++;
            }
            $i++;
        }
        return $arr;
    }

    public function viloyatlar()
    {
        $vil=Region::orderBy('id')->get();
//        dd($vil);
        return $vil;
    }

    public function month()
    {
        $arr[0]=['id'=>31, 'name'=>'Yanvar'];
        $arr[1]=['id'=>28, 'name'=>'Fevral'];
        $arr[2]=['id'=>31, 'name'=> 'Mart'];
        $arr[3]=['id'=>30, 'name'=>'Aprel'];
        $arr[4]=['id'=>31, 'name'=>'May'];
        $arr[5]=['id'=>30, 'name'=>'Iyun'];
        $arr[6]=['id'=>31, 'name'=>'Iyul'];
        $arr[7]=['id'=>31, 'name'=>'Avgust'];
        $arr[8]=['id'=>30, 'name'=>'Sentabr'];
        $arr[9]=['id'=>31, 'name'=>'Oktabr'];
        $arr[10]=['id'=>30, 'name'=>'Noyabr'];
        $arr[11]=['id'=>31, 'name'=>'Dekabr'];
        return $arr;
    }

    public function endmonth($month,$months)
    {
        $i=1;
        foreach ($months as $m){
            if (date('m',strtotime($month))==$i){
                $endM=$m['id'];
            }
            $i++;
        }
        return $endM;

    }

    public function day_sold($elchi,$days,$sold)
    {
        $i=0;
        $tot_sold=[];
        foreach ($days as $day){
            $j=0;
            $tot_sold[$i]=0;
            foreach ($elchi as $item){
                $tot_sold[$i]+=$sold[$item->id][$i]['sold'];
                $j++;
            }
            $i++;
        }
        return $tot_sold;
    }

    public function total_fact($fact)
    {
        $tot_fact=0;
        foreach ($fact as $item){
            $tot_fact+=$item;
        }
        return $tot_fact;
    }
    public function total_prog($prog)
    {
        $tot_prog=0;
        foreach ($prog as $item){

            $tot_prog+=$item;
        }
        return $tot_prog;
    }
    public function total_plan($plan)
    {
        $tot_plan=0;
        foreach ($plan as $item){
            $tot_plan+=$item;
        }
        return $tot_plan;
    }
    public function total_planday($planday)
    {
        $tot_planday=0;
        foreach ($planday as $item){
            $tot_planday+=$item;
        }
        return $tot_planday;

    }
    public function total_week($haftalik,$days, $month)
    {

        if($haftalik == []) {
            return [];
        }
        $total_week=[];
        for ($i = 0; $i < 4; $i++){
            $total_week[$i]=0;
            foreach ($haftalik as $val){
                if(isset($val[$i])) {
                    $total_week[$i]+=$val[$i];
                }
            }
        }
       return $total_week;

    }

    public function gsh($elchi)
    {

    }

    public function bestMonthSold()
    {
        $b_date = $this->getFirstDate(date('Y-m-d'));
        $b_date = date('Y-m-d',(strtotime ( '-10 day' , strtotime ( $b_date ) ) ));
        $e_date = date('2022-09-01');
        $mustang = [];

        $arrayDate = array();
                $Variable1 = strtotime($b_date);
                $Variable2 = strtotime($e_date);
                $sum = 0;
                for ($currentDate = $Variable1; $currentDate >= $Variable2;$currentDate -= (30*86400))
                {
                    $begin_month = $this->getFirstDate(date('Y-m-d',$currentDate));
                    $end_month = $this->getLastDate(date('Y-m-d',$currentDate));
                   $mustang[] = array('begin' => $begin_month,'end' => $end_month);
                }
        return $mustang;
    }
    public function bestRegion($mustang,$id)
    {
        $arr=[];
        $max=0;
        foreach ($mustang as $key => $value) {
            $sum = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.price_product*tg_productssold.number) as allprice')
                ->where('user_id',$id)
                ->whereDate('tg_productssold.created_at','>=',$value['begin'])
                ->whereDate('tg_productssold.created_at','<=',$value['end'])
                ->get()[0]->allprice;

            if($sum == NULL)
            {
                $sum=0;
            }
            if($sum > $max)
            {
                $max = $sum;
                $index=$value;
            }
        }
        if($max == 0)
        {
            $arr[]=array('date' => 0, 'bestsum' => $max);
        }else{
            $arr[]=array('date' => date('m.Y',strtotime($index['begin'])), 'bestsum' => numb($max),'bestsumText' => $max);
        }

    return $arr;
    }
    public function getFirstDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->firstOfMonth()
                        ->format('Y-m-d');
        return $d;
    }
    public function getLastDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        return $d;
    }


}
