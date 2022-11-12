<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    public function index()
    {
        $pharmacies=Pharmacy::all();

        return view('compare.index',compact('pharmacies'));
    }

    public function show($pharmacy_id,$time)
    {
        $date_begin=Accept::orderBy('date')->first('date');
//        dd($date_begin->date);
        $stock=Stock::where('pharmacy_id',$pharmacy_id)->select('date_time')->orderBy('date_time')->groupBy('date_time')->get();
        $med=Medicine::orderBy('id')->get();
//        dd($stock);
        $arr_sold=[];
        $i=0;
        $stocks=[];

        $arr_qol_all=[];
        $arr_accepts=[];
        $compare=[];
        foreach ($stock as $s){


            $arr_qol=[];
            $st=Stock::where('date_time',$s->date_time)->get();
            foreach ($st as $item){
                if($item->number==null){
                    $arr_qol[$item->medicine_id]=0;

                }else{
                    $arr_qol[$item->medicine_id]=$item->number;
                }

            }
//            dd($arr_qol);
            if($i==0){
                $a=$s->date_time;
            }
            else{

                $arr_sold[]=DB::table('tg_productssold')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharm_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$a)
                    ->whereDate('created_at','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->get();
                if(isset($arr_sold[$i-1])){
                    foreach ($arr_sold[$i-1] as $item2){
                        $arr_qol[$item2->medicine_id]=$arr_qol[$item2->medicine_id]-$item2->sold;
                    }
                }

//                $arr_accept=Accept::whereDate('date_time','>=',$a)->whereDate('date_time','<=',$s->date_time)->get();
                $arr_accept=DB::table('tg_accepts')
                    ->selectRaw('SUM(number) as sold,medicine_id')
                    ->where('pharmacy_id',$pharmacy_id)
                    ->whereDate('date_time','>=',$a)
                    ->whereDate('date_time','<=',$s->date_time)
                    ->orderBy('medicine_id')
                    ->groupBy('medicine_id')->get();


                if(isset($arr_accept)){
                    foreach ($arr_accept as $item3){

                        $arr_qol[$item3->medicine_id]=$arr_qol[$item3->medicine_id]+$item3->sold;
                    }

                }
                $arr_accepts[]=$arr_accept;


                $a=$s->date_time;

//                $k=\App\Models\Stock::where('medicine_id',7)->where('pharmacy_id',$pharmacy_id)->where('date_time',$s->date_time)->first('number');
//                dd($k->number);
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
                $compare[$i]='bg-danger';
            }
          $i++;

        }
//        dd($arr_accepts[2]);
//        foreach ($arr_sold[0] as $s){
//            dd($s->medicine_id);
//        }
//        dd($arr_sold);

//        dd($arr_qol_all);



        return view('compare.show',compact('compare','arr_qol_all','pharmacy_id','stock','arr_accepts','stocks','med','arr_sold'));
    }
}
