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

    public function show($pharmacy_id,$month)
    {
        $ser=new ElchilarService();
        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);

        $medicine = Medicine::orderBy('id')->get();
        $stocks = [];
        $accepts = [];
        $solds = [];
        $accept = 0;
        foreach($medicine as $m)
        {
            $stock=Stock::where('pharmacy_id',$pharmacy_id)
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('medicine_id',$m->id)
            ->sum('number');

            $stocks[$m->id] = $stock;

            $accept=Accept::where('pharmacy_id',$pharmacy_id)
            ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('medicine_id',$m->id)
            ->sum('number');

            $accepts[$m->id] = $accept;

            $dated = Stock::where('pharmacy_id',$pharmacy_id)
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->orderBy('id','DESC')
            ->first();

            if($dated)
            {
                $dat = $dated->date_time;

                $sold=DB::table('tg_productssold')->where('pharm_id',$pharmacy_id)
                ->whereDate('created_at','>=',date('Y-m-d',strtotime($dat)))
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->where('medicine_id',$m->id)
                ->sum('number');

            $solds[$m->id] = $sold;
            }else{
                $sold=DB::table('tg_productssold')->where('pharm_id',$pharmacy_id)
                ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
                ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
                ->where('medicine_id',$m->id)
                ->sum('number');
            $solds[$m->id] = $sold;

            }



        }

        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');

        return view('compare.show2',compact('accepts','stocks','solds','medicine','pharm','months','month','pharmacy_id'));

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
