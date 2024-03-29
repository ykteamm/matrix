<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Region;
use App\Models\Stock;
use App\Models\User;
use App\Services\AcceptService;
use App\Services\ElchilarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    public $service;

    public function __contruct(AcceptService $service)
    {
        $this->service=$service;
    }
    public function index()
    {
        $id=Session::get('user')->id;

        $user = User::find($id);


        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $userarrayreg = Region::pluck('id')->toArray();
            }
            else{
                $userarrayreg = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $userarrayreg[] = $key;
                        }
                    }
            }


        $pharmacy = Pharmacy::whereIn('region_id',$userarrayreg)->get();

        return view('stockProduct.index',compact('user','pharmacy'));
    }



    public function show($pharmacy_id,$month)
    {
//       if($pharmacy_id==8){
//           $aa=Stock::where('pharmacy_id',8)->delete();
//       }
        $ser=new ElchilarService();
        $months=$ser->month();
        $endofmonth=$ser->endmonth($month,$months);
        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');
        $med=Medicine::orderBy('id')->get();
        $stock_date=DB::table('tg_stocks')
            ->select('date')
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('pharmacy_id',$pharmacy_id)
            ->groupBy('date')
            ->orderBy('date')->get();
        $stock=DB::table('tg_stocks')
            ->select('number','medicine_id','date')
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->where('pharmacy_id',$pharmacy_id)
            ->orderBy('date')->get();
//        dd($pharm);
        $count=$stock_date->count();
        $id=Session::get('user')->id;

        $calendar = Calendar::all();
        
        // dd($calendar);

        return view('stockProduct.show',compact('month','pharm','months','med','stock','pharmacy_id','stock_date','count','id','calendar'));
    }

    public function delete($pharmacy_id,$date)
    {
        $t=Stock::where('date',$date)->where('pharmacy_id',$pharmacy_id)->delete();
        return redirect()->route('stock.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }

    public function create($pharmacy_id)
    {
        $id=Session::get('user')->id;
        $user=User::where('id',$id)->first();
        $medicines=Medicine::all();
        $pharmacies=DB::table('tg_pharm_users')
            ->where('user_id',$id)
            ->where('pharmacy_id',$pharmacy_id)
            ->selectRaw('user_id, pharmacy_id, tg_pharmacy.name as name, tg_pharmacy.region as region,tg_pharmacy.slug as slug')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_pharm_users.pharmacy_id')
            ->get();
//        dd($pharmacies);
        return view('stockProduct.create',compact('id','pharmacy_id','medicines','pharmacies','user'));
    }
    public function store(Request $request,$pharmacy_id)
    {
        $id=Session::get('user')->id;
        $r=$request->all();
        unset($r['_token']);
        $created_by=$r['created_by'];
        if(isset($r['meeting-time'])){
            $date_time=$r['meeting-time'];
        }else{
            $date_time=date('Y-m-d H-i-s');
        }
        $q=Stock::where('date',$date_time)->first();
        

        if(!isset($q)){
            unset($r['meeting-time']);
            unset($r['created_by']);
//        dd($r);
            foreach ($r as $key=>$item){
//            dd($item);
                $stock =new Stock();
                $stock->medicine_id=substr($key,3);
                $stock->number=$item;
                $stock->date=$date_time;
                $stock->date_time=$date_time;
                $stock->created_by=$created_by;
                $stock->updated_by=$created_by;
                $stock->pharmacy_id=$pharmacy_id;
                $stock->save();

            }
        }

        return redirect()->route('stock.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }


    public function edit($pharmacy_id, $date)
    {
        $stocks=Stock::where('pharmacy_id',$pharmacy_id)
            ->where('date',$date)->with('medicine')
            ->orderBy('medicine_id')
            ->get();
        return view('stockProduct.edit',compact('stocks','pharmacy_id','date'));
    }
    public function update(Request $request,$pharmacy_id)
    {
//        dd($request->all());
        $i=0;
        $user_id=Session::get('user')->id;

        foreach ($request['number'] as $item)
        {
            $s=Stock::where('id',$request['id'][$i])->first();

            $s->number=$item;
            $s->updated_by=$user_id;
            $s->update();
            $i++;
        }
        return redirect()->route('stock.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m')]);
    }




}
