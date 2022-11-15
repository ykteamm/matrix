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
            $stocks[$i]=$ss;
            $arr_qol_all[]=$arr_qol;
            $count=0;
            foreach ($med as $l){
                foreach ($ss as $item){
                    if($arr_qol[$l->id]==$item->number && $item->medicine_id==$l->id){
                        $count++;
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



        return view('compare.show',compact('pharm','month','months','stock_all','compare','arr_qol_all','pharmacy_id','stock','arr_accepts','stocks','med','arr_sold'));
    }
}
