<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmUser;
use App\Models\Stock;
use App\Models\User;
use App\Services\AcceptService;
use App\Services\ElchilarService;
use App\Services\ElchiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AcceptProductController extends Controller
{
    public $service;

    public function __contruct(AcceptService $service)
    {
        $this->service=$service;
    }
    public function index()
    {
        $id=Session::get('user')->id;
//       $elchi_service=new ElchiService();
//       $date=$elchi_service->day($time);
//       $date_begin=$date->date_begin;
//       $date_end=$date->date_end;
//       $date_text=$date->dateText;
//       $user=User::with('');

        $pharmacies=User::where('id',$id)->with('admin_pharmacies')->get();
//        dd($pharmacies[0]->admin_pharmacies[0]);
        $user=User::where('id',$id)->first();
        $count=$pharmacies[0]->admin_pharmacies->count();

        return view('acceptProduct.index',compact('pharmacies','user','count'));
    }

    public function show($pharmacy_id,$month)
    {
        $ser=new ElchilarService();
        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);
//        dd($months);
        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');
        $med=DB::table('tg_medicine')
            ->selectRaw('tg_medicine.name,tg_medicine.id,tg_prices.price')
            ->where('tg_shablon_pharmacies.pharmacy_id',$pharmacy_id)
            ->join('tg_prices','tg_prices.medicine_id','tg_medicine.id')
            ->join('tg_shablon_pharmacies','tg_shablon_pharmacies.shablon_id','tg_prices.shablon_id')
            ->groupBy('tg_medicine.id','tg_medicine.name','tg_prices.price')
            ->orderBy('tg_medicine.id')
            ->get();
        $accept_date=DB::table('tg_accepts')
            ->selectRaw('SUM(price) as all_price,created_at')
            ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('pharmacy_id',$pharmacy_id)
            ->groupBy('created_at')
            ->orderBy('created_at')->get();

        $accept=DB::table('tg_accepts')
            ->select('number','medicine_id','created_at','price')
            ->whereDate('created_at','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('created_at','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('pharmacy_id',$pharmacy_id)->orderBy('created_at')->get();
        $count=$accept_date->count();
        $id=Session::get('user')->id;

        return view('acceptProduct.show',compact('month','pharm','months','med','accept','pharmacy_id','accept_date','count','id'));
    }


    public function store(Request $request,$pharmacy_id)
    {


        $id=Session::get('user')->id;
        $r=$request->all();

//        dd($r);
        unset($r['_token']);
        $created_by=$r['created_by'];

            unset($r['meeting-time']);
            unset($r['created_by']);
            $i=0;
            foreach ($r as $key=>$item){

                if($i==0){
                    if($item==null){
                        $item=0;
                    }
                    $accept =new Accept();
                    $accept->medicine_id=substr($key,3);
                    $accept->number=$item;
                    $accept->created_by=$created_by;
                    $accept->updated_by=$created_by;
                    $accept->pharmacy_id=$pharmacy_id;
                }
                if($i==1){
                    $accept->price=$item*$accept->number;
                    $accept->save();
                }
                if($i==0){
                    $i=1;
                }else{
                    $i=0;
                }


            }


        return redirect()->route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }



    public function edit($pharmacy_id, $created_at)
    {

        $accept=Accept::where('pharmacy_id',$pharmacy_id)
            ->where('created_at',$created_at)->with('medicine')
            ->orderBy('medicine_id')
            ->get();
        return view('acceptProduct.edit',compact('accept','pharmacy_id','created_at'));
    }

    public function update(Request $request,$pharmacy_id)
    {
//        dd($request->all());
//        $request->validate([
//            'number'=>'required'
//        ]);

        $i=0;

        $user_id=Session::get('user')->id;
//        dd($request->all());
        foreach ($request['number'] as $item){
            $s=Accept::where('id',$request['id'][$i])->first();

//            dd($s->medicine_id);
            $med=DB::table('tg_medicine')
                ->selectRaw('tg_medicine.name,tg_medicine.id,tg_prices.price')
                ->where('tg_medicine.id',$s->medicine_id)
                ->where('tg_shablon_pharmacies.pharmacy_id',$pharmacy_id)
                ->join('tg_prices','tg_prices.medicine_id','tg_medicine.id')
                ->join('tg_shablon_pharmacies','tg_shablon_pharmacies.shablon_id','tg_prices.shablon_id')
                ->groupBy('tg_medicine.id','tg_medicine.name','tg_prices.price')
                ->orderBy('tg_medicine.id')
                ->first();

            $s->number=$item;
            $s->price=$item*$med->price;
            $s->updated_by=$user_id;
            $s->update();
            $i++;
        }

        return redirect()->route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }

    public function delete($pharmacy_id,$date)
    {
        $t=Accept::where('created_at',$date)->where('pharmacy_id',$pharmacy_id)->delete();
        return redirect()->route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }
}
