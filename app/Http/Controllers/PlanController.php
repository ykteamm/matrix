<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Models\Sold;
use App\Services\PlanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     *
     */
    public $service;

    public function __construct(PlanService $service)
    {
        $this->service=$service;
    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create($id)
    {
        $med=Medicine::all();

        $plans=Plan::where('user_id',$id)->get();

        return view('plan.create',[
            'user_id'=>$id,
            'plans'=>$plans,
            'medicines'=>$med
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request,$id)
    {
        $this->service->store($request, $id);
       return redirect()->route('elchi',['id'=>$id,'time'=>'today']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *'number',
    'medicine_id',
    'user_id',
    'order_id',
    'price_product'
     * date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
     */
    public function show($id,$startday)
    {
//        $d=Sold::all();
//        foreach($d as $item){
//            Sold::where('user_id',$id)->delete();
//        }
//        return 'aa';
//        $ps=ProductSold::whereNotNull('user_id')->whereNotNull('order_id')->whereBetween('created_at', [date("Y-m-d", strtotime('-1 month', strtotime((Carbon::now()->startOfMonth())))), date("Y-m-d", strtotime('-1 month', strtotime((Carbon::now()->endOfMonth()))))])->get();
//        foreach ($ps as $item){
//            $sold=new Sold();
//            $item->created_at=date("Y-m-d", strtotime('1 month', strtotime(($item->created_at))));
////            dd($item->user_id);
//            $sold->number=$item->number;
//            $sold->created_at=$item->created_at;
//            $sold->medicine_id=$item->medicine_id;
//            $sold->user_id=$item->user_id;
//            $sold->order_id=$item->order_id;
//            $sold->price_product=$item->price_product;
//            $sold->is_active=$item->is_active;
//            $sold->save();
//        }

        dd($id);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
//$d=Plan::all();
//        foreach($d as $item){
//            Plan::where('user_id',$id)->delete();
//        }
//        return 'aa';
    public function edit($id)
    {

        $med=Medicine::all();
        $plans=Plan::where('user_id',$id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
//        dd($plans);
        return view('plan.edit',[
           'user_id'=>$id,
           'plans'=>$plans,
           'medicines'=>$med
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $r=$request->all();
        unset($r['_token']);
        date_default_timezone_set('Asia/Tashkent');
        $cal=Calendar::where('year_month','10.2022')->first();
        $arr=json_decode($cal->day_json);

        $interval=0;
        for($i=0;$i<date('d');$i++){
            if($arr[$i]=='true'){
                $interval++;
            }
        }
        foreach ($r as $key => $item){
            $plan=Plan::where('user_id',$id)
                ->where('medicine_id',substr($key,8))
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->first();
            if (isset($plan)&&($item!=0)){
            $workday=$cal->work_day;
            $workday1=0;
            for($i=0;$i<date('d');$i++){
                if ($arr[$i]=='true'){
                    $workday1++;
                }
            };
            $month_end= date('d', strtotime('last day of this month', time()));
            $old_one_day_plan=$plan->number/$cal->work_day;
            $plan->medicine_id= substr($key,8);
            $plan->number=round($item+$old_one_day_plan*$workday1);
            $plan->user_id=$id;

            $plan->update();
            $new_work_day=0;
            for ($i=date('d');$i<=$month_end;$i++){
                if ($arr[$i-1]=='true'){
                    $new_work_day++;
                }
            }
            $new_one_day_plan=
                $item/$new_work_day;
            $pw=PlanWeek::where('plan_id',$plan->id)->where('medicine_id',substr($key,8))->whereBetween('endday', [Carbon::now(), Carbon::now()->endOfMonth()])->get();
            $count=PlanWeek::where('plan_id',$plan->id)->where('medicine_id',substr($key,8))->whereBetween('endday', [Carbon::now(), Carbon::now()->endOfMonth()])->count();
            for ($i=0;$i<$count;$i++){

                if($i==0){
                    $interval1=0;
                    $interval2=0;
//                    dd(date('d',strtotime($pw[$i]->startday)));
                    for($j=date('d',strtotime($pw[$i]->startday));$j<date('d');$j++){
                        if($arr[$j]=='true'){
                            $interval1++;
                        }
                    }
                    for($j=date('d')-1;$j<date('d',strtotime($pw[$i]->endday));$j++){
                        if($arr[$j]=='true'){
                            $interval2++;
                        }
                    }
                    $pw[$i]->plan=round($interval1*$old_one_day_plan)+round($new_one_day_plan*$interval2);
                    $item=$item-round($new_one_day_plan*$interval2);
                }else{
                    if($i!=$count-1){
                    $pw[$i]->plan=round($pw[$i]->workday*$new_one_day_plan);
                    $item=$item-round($pw[$i]->workday*$new_one_day_plan);
                    }
                }
                if ($i==$count-1){
                    $pw[$i]->plan=$item;
                }
                $pw[$i]->update();


            }

            }
            elseif ($item!=null){
                $plan=new Plan();

                if($item!=0){
                    $plan->medicine_id= substr($key,8);
                    $plan->number=$item;
                    $plan->user_id=$id;
                    $plan->save();
                        $workday=$cal->work_day;
                        $count=0;
                        $start=0;
                        $sikl=0;
                        if($workday>0&&$workday<14){
                            $count==1;
                        }elseif ($workday>=14&&$workday<=20){
                            $count=2;
                        }elseif ($workday>=21&&$workday<=26){
                            $count=3;
                        }else{
                            $count=4;
                        }
//                dd($plan->number);
                        $planwork=$plan->number/$cal->work_day;
                        for($i=0;$i<$count;$i++){
                            $pw=new PlanWeek();
                            $pw->plan_id=$plan->id;
                            $pw->user_id=$plan->user_id;
                            if($workday>13){
                                $pw->workday=7;
                                $workday=$workday-7;
                            }else{
                                $pw->workday=$workday;

                            }
                            $ct=0;
                            $cf=0;
                            $l=$pw->workday;
                            for($j=$start;$j<$start+$l;$j++){
                                if($arr[$j]=='true'){
                                    $ct++;
                                }else{
                                    $cf++;
                                    $l++;
                                }

                                if($ct==1){
                                    $d=$j;
                                    $d=$d.' day';
                                    $pw->startday=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
                                }


                                if($ct==$pw->workday){
                                    $d=$j;
                                    $start=$j+1;
                                    $d=$d.' day';

                                    $pw->endday=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
                                    if($i!=$count-1){
                                        $pw->plan=round($planwork*$pw->workday);
                                    }else{
                                        $pw->plan=$plan->number;
                                    }

                                    $plan->number=$plan->number-$pw->plan;
                                    $pw->calendar_id=$cal->id;
                                    $pw->save();
                                    break;

                                }
                            }

                        }

                }
            }
        }
        return redirect()->route('elchi',['id'=>$id,'time'=>'today']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        //
    }
}
