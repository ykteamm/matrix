<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Models\Stock;
use App\Models\User;
use App\Services\ElchilarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    public function index()
    {
        $pharmacies=Pharmacy::all();

        return view('compare.index',compact('pharmacies'));
    }

    public function show2($pharmacy_id,$month)
    {
        $ser=new ElchilarService();
        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);
        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');
        $stock=Stock::where('pharmacy_id',$pharmacy_id)
            ->select('date_time')
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->orderBy('date_time')
            ->groupBy('date_time')->get();
        $med=Medicine::orderBy('id')->get();
        $arr_sold=[];
        $i=0;
        $stocks=[];

        $arr_qol_all=[];
        $arr_accepts=[];
        $compare=[];
        $stock_all=[];
        $comp=[];
        foreach ($stock as $s){


            $arr_qol=[];
            $st=Stock::where('date_time',$s->date_time)->get();

//            dd($arr_qol);
            if($i==0){
                foreach ($st as $item){
                    if($item->number==null){
                        $arr_qol[$item->medicine_id]=0;

                    }else{
                        $arr_qol[$item->medicine_id]=$item->number;
                    }

                }
                $a=$s->date_time;
            }
            else{
                $st=Stock::where('date_time',$a)->get();
                foreach ($st as $item){
                    if($item->number==null){
                        $arr_qol[$item->medicine_id]=0;

                    }else{
                        $arr_qol[$item->medicine_id]=$item->number;
                    }

                }
                $stock_all[]=$arr_qol;


                $arr_sold[]=DB::table('tg_productssold')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharm_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$a)
                    ->whereDate('created_at','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->pluck('sold','medicine_id');
                if(isset($arr_sold[$i-1])){
                    foreach ($arr_sold[$i-1] as $key=> $item2){
                        $arr_qol[$key]=$arr_qol[$key]-$item2;
                    }
                }

                $arr_accept=DB::table('tg_accepts')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharmacy_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$a)
                    ->whereDate('created_at','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->pluck('sold','medicine_id');
                if(isset($arr_accept)){
                    foreach ($arr_accept as $key=>$item3){

                        $arr_qol[$key]=$arr_qol[$key]+$item3;
                    }

                }
                $arr_accepts[]=$arr_accept;


                $a=$s->date_time;

            }
            $ss=Stock::where('pharmacy_id',$pharmacy_id)->where('date_time',$s->date_time)->with('medicine')->orderBy('medicine_id')->get();
//            dd($ss[1]);
            $t=1;

//            foreach ($ss as $item){
//                if($item->number==$arr_qol[$t]){
//
//                }
//                $t++;
//            }
            $stocks[$i]=$ss;
            $arr_qol_all[]=$arr_qol;
            $count=0;
            foreach ($med as $l){
                foreach ($ss as $item){
                    if($item->medicine_id==$l->id){

                        if($arr_qol[$l->id]==$item->number  ){
                            $count++;
                            $comp[$i][$l->id]='background-color: #1a73e8';
                        }
                        else{
                            $comp[$i][$l->id]='background-color:red';
                        }
                    }

                }
            }
            $c=$med->count();
            if($count==$c){
                $compare[$i]='bg-success';
            }
            else{
                $compare[$i]='bg-danger text-white';
            }
          $i++;

        }



        return view('compare.show',compact('comp','pharm','month','months','stock_all','compare','arr_qol_all','pharmacy_id','stock','arr_accepts','stocks','med','arr_sold'));
    }


    public function show($pharmacy_id,$month)
    {
        $ser=new ElchilarService();

        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);

        $last_month = date('Y-m',strtotime('-1 month',strtotime($month)));
        $endof_last_month=$ser->endmonth($last_month,$months);

        $medicine = Medicine::with(['pricem' => function($q) {
            $q->where('shablon_id', 3);

        }])->orderBy('id')->get();

        // User::with(['roles' => function($q) use($faculty_id){
        //     $q->where('user_roles.faculty_id', $faculty_id);
        //     }])
        // ->get();

        // dd($medicine[0]->priceSh[0]->price);
        $accept = 0;

        $month_date=Stock::where('pharmacy_id',$pharmacy_id)
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->distinct('date_time')->pluck('date_time')->toArray();
        
        $count_date = count($month_date);
        
        $last_month_date=Stock::where('pharmacy_id',$pharmacy_id)
        // ->whereDate('date','>=',date('Y-m',strtotime($last_month)).'-01')
        ->whereDate('date','<=',date('Y-m',strtotime($last_month)).'-'.$endof_last_month)
        ->orderBy('id','DESC')->first();
        if($last_month_date)
        {
            array_unshift($month_date,$last_month_date->date_time);
        }


        // dd($month_date);
        $count = count($month_date);

        $dates = [];
        $solds = [];
        $accepts = [];
        $first_stocks = [];
        $second_stocks = [];
        $stocks = [];

        for ($i=0; $i < $count-1; $i++) { 
            $dates[$i][] = $month_date[$i];
            $dates[$i][] = $month_date[$i+1];

        }

        if($last_month_date)
        {
            $dates[count($dates)][] = $last_month_date->date_time;
            $dates[count($dates)-1][] = $month_date[count($month_date)-1];
        }
        

        // dd($dates);
        
            foreach ($dates as $key => $value) {
                foreach($medicine as $m)
                {
                    $sold=DB::table('tg_productssold')->where('pharm_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$value[0])
                    ->whereDate('created_at','<=',$value[1])
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $solds[$key][$m->id] = $sold;

                    $accept=Accept::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$value[0])
                    ->whereDate('created_at','<=',$value[1])
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $accepts[$key][$m->id] = $accept;

                    $stock1 = Stock::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('date','=',date('Y-m-d',strtotime($value[0])))
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $first_stocks[$key][$m->id] = $stock1;

                    $stock2 = Stock::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('date','=',date('Y-m-d',strtotime($value[1])))
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $second_stocks[$key][$m->id] = $stock2;
                }

            }


        
        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');

        return view('compare.show',compact('count_date','dates','accepts','first_stocks','second_stocks','solds','medicine','pharm','months','month','pharmacy_id'));

        return $solds;

        $ser=new ElchilarService();
        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);
        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');
        $stock=Stock::where('pharmacy_id',$pharmacy_id)
            ->select('date_time')
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->orderBy('date_time')
            ->groupBy('date_time')->get();


        $med=Medicine::orderBy('id')->get();


        $arr_sold=[];
        $i=0;
        $stocks=[];

        $arr_qol_all=[];
        $arr_accepts=[];
        $compare=[];
        $stock_all=[];
        $comp=[];

        foreach ($stock as $s){


            $arr_qol=[];
            $st=Stock::where('date_time',$s->date_time)->get();

//            dd($arr_qol);
            $a=$s->date_time;

            // return $a;

            // if($i==0){
            //     foreach ($st as $item){
            //         if($item->number==null){
            //             $arr_qol[$item->medicine_id]=0;

            //         }else{
            //             $arr_qol[$item->medicine_id]=$item->number;
            //         }

            //     }
            // }
            // else{
                $st=Stock::where('date_time',$a)->get();
                foreach ($st as $item){
                    if($item->number==null){
                        $arr_qol[$item->medicine_id]=0;

                    }else{
                        $arr_qol[$item->medicine_id]=$item->number;
                    }

                }
                $stock_all[]=$arr_qol;


                $arr_sold[]=DB::table('tg_productssold')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharm_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$a)
                    ->whereDate('created_at','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->pluck('sold','medicine_id');
                if(isset($arr_sold[$i-1])){
                    foreach ($arr_sold[$i-1] as $key=> $item2){
                        $arr_qol[$key]=$arr_qol[$key]-$item2;
                    }
                }

                $arr_accept=DB::table('tg_accepts')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharmacy_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$a)
                    ->whereDate('created_at','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->pluck('sold','medicine_id');
                if(isset($arr_accept)){
                    foreach ($arr_accept as $key=>$item3){

                        $arr_qol[$key]=$arr_qol[$key]+$item3;
                    }

                }
                $arr_accepts[]=$arr_accept;


                $a=$s->date_time;

            // }

            $ss=Stock::where('pharmacy_id',$pharmacy_id)->where('date_time',$s->date_time)->with('medicine')->orderBy('medicine_id')->get();
            $t=1;
            $stocks[$i]=$ss;
            $arr_qol_all[]=$arr_qol;
            $count=0;
            foreach ($med as $l){
                foreach ($ss as $item){
                    if($item->medicine_id==$l->id){

                        if($arr_qol[$l->id]==$item->number  ){
                            $count++;
                            $comp[$i][$l->id]='background-color: #1a73e8';
                        }
                        else{
                            $comp[$i][$l->id]='background-color:red';
                        }
                    }

                }
            }
            $c=$med->count();
            if($count==$c){
                $compare[$i]='bg-success';
            }
            else{
                $compare[$i]='bg-danger text-white';
            }
          $i++;

        }

        // return $arr_sold;

        return view('compare.show',compact('comp','pharm','month','months','stock_all','compare','arr_qol_all','pharmacy_id','stock','arr_accepts','stocks','med','arr_sold'));
    }
}
