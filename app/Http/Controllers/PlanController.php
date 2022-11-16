<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Models\Shablon;
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
        $med=Medicine::orderBy('id')->get();
        $shablons=Shablon::all();
        $plans=Plan::where('user_id',$id)->get();

        return view('plan.create',[
            'shablons'=>$shablons,
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


        $med=Medicine::orderBy('id')->get();

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
        for($i=0;$i<date('d')*1;$i++){
            if($arr[$i]=='true'){
                $interval++;
            }
        }
        $qll=0;
        foreach ($r as $key => $item){

            $plan=Plan::where('user_id',$id)
                ->where('medicine_id',substr($key,8))
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->first();
            $new_work_day=0;
            $month_end= date('d', strtotime('last day of this month', time()));
            for ($i=date('d')*1;$i<=$month_end;$i++){
                if ($arr[$i-1]=='true'){
                    $new_work_day++;
                }
            }
            if (isset($plan)&&($item!=0)&&$item!=null){
            $workday=$cal->work_day;
            $workday1=0;
            for($i=0;$i<date('d');$i++){
                if ($arr[$i]=='true'){
                    $workday1++;
                }
            };
            $old_one_day_plan=$plan->number/$cal->work_day;
            $plan->medicine_id= substr($key,8);
            $plan->number=round($item+$old_one_day_plan*$workday1);
            $plan->user_id=$id;


            $new_one_day_plan= $item/$new_work_day;
            $pw=PlanWeek::where('plan_id',$plan->id)->where('medicine_id',substr($key,8))->whereBetween('endday', [Carbon::now(), Carbon::now()->endOfMonth()])->get();
            $count=PlanWeek::where('plan_id',$plan->id)->where('medicine_id',substr($key,8))->whereBetween('endday', [Carbon::now(), Carbon::now()->endOfMonth()])->count();
            for ($i=0;$i<$count;$i++){

                if($i==0){
                    $interval1=0;
                    $interval2=0;
//                    dd(date('d',strtotime($pw[$i]->startday)));
                    for($j=date('d',strtotime($pw[$i]->startday))*1;$j<date('d')*1;$j++){
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
            $ppp=PlanWeek::where('medicine_id',$plan->medicine_id)->where('user_id',$plan->user_id)->whereBetween('endday', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            $plan->number=0;
            foreach ($ppp as $p){
                $plan->number+=$p->plan;
            }
            $plan->update();
            }
            elseif ($item!=null){
                $plan=new Plan();

                if($item!=0){
                    $plan->medicine_id= substr($key,8);
                    $plan->number=$item;
                    $plan->user_id=$id;
                    $planweekdays=Plan::with('planweek')->latest()->first();
                    $count=0;
                    foreach ($planweekdays->planweek as $pweek){
                        $count++;
                    }
                    $plan->save();
                    $w=0;
                    foreach ($planweekdays->planweek as $pweek){
                        $w++;
                        $pw=new PlanWeek();
                        $pw->user_id=$id;
                        $pw->medicine_id=substr($key,8);
                        $pw->workday=$pweek->workday;
                        $pw->startday=$pweek->startday;
                        $pw->endday=$pweek->endday;
                        $pw->calendar_id=$pweek->calendar_id;
                        $pw->plan_id=$plan->id;
                        if(date('d',strtotime($pweek->endday))*1>=date('d')*1){
                            if ($w!=$count) {
                                if($pw->startday>=date('d')*1){
                                    $pw->plan=$new_one_day_plan*$pweek->workday;
                                }else{
                                    $interval2 = 0;
                                    for ($j = date('d') - 1; $j < date('d', strtotime($pw->endday))*1; $j++) {
                                        if ($arr[$j] == 'true') {
                                            $interval2++;
                                        }
                                    }
                                    $pw->plan = round($new_one_day_plan * $interval2);
                                    $pw->save();
                                    $item = $item - round($new_one_day_plan * $interval2);
                                }

                            }else{
                                $pw->plan=$item;
                                $pw->save();
                            }

                        }else{
                            $pw->plan=0;
                            $pw->save();
                        }
                    }

//

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
