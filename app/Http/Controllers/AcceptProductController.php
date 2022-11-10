<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmUser;
use App\Models\Stock;
use App\Models\User;
use App\Services\AcceptService;
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
    public function index($time)
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
        return view('acceptProduct.index',compact('pharmacies','user'));
    }

    public function show($pharmacy_id)
    {

        $pharm=Pharmacy::where('id',$pharmacy_id)->first();

        $accept=Accept::where('pharmacy_id',$pharmacy_id)->get();
        $pharmacy=DB::table('tg_accepts')
            ->selectRaw('SUM(tg_accepts.number) as amount,medicine_id,pharmacy_id, tg_medicine.name as name,tg_pharmacy.name as pharmacy_name')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_accepts.pharmacy_id')
            ->join('tg_medicine','tg_medicine.id','tg_accepts.medicine_id')
            ->groupBy('pharmacy_id','medicine_id','tg_medicine.name','tg_pharmacy.name')->get();

        $accepts=Accept::where('pharmacy_id',$pharmacy_id)->with('medicine','user_created','user_updated')->orderBy('created_at','DESC')->get();
//        dd($pharmacies);
//        dd($pharmacy);
//        dd($accepts);
        return view('acceptProduct.show',compact('accepts','pharmacy_id','pharmacy','accept','pharm'));

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
        return view('acceptProduct.create',compact('id','pharmacy_id','medicines','pharmacies','user'));
    }

    public function store(Request $request,$pharmacy_id)
    {
        $id=Session::get('user')->id;
        $r=$request->all();
        unset($r['_token']);
        $created_by=$r['created_by'];
        foreach ($r as $key=>$item){
            if($item!=null &&$key!='created_by'&&$key!='pharmacy_id' ){
               $accept =new Accept();
               $accept->medicine_id=substr($key,3);
               $accept->number=$item;
               $accept->created_by=$created_by;
               $accept->updated_by=$created_by;
               $accept->pharmacy_id=$pharmacy_id;
               $accept->save();
            }
        }
        return redirect()->route('accept.med.show',['id'=>$pharmacy_id]);
    }

    public function edit(Request $request, $pharmacy_id)
    {

        $accept=Accept::where('pharmacy_id',$pharmacy_id)->where()->with('medicine')->first();
        return view('acceptProduct.edit',compact('accept',$pharmacy_id));
    }

    public function update(Request $request,$id)
    {
//        dd($request->all());
        $request->validate([
            'number'=>'required'
        ]);
        $user_id=Session::get('user')->id;
        $r=$request->all();
        unset($r['_token']);
        dd($r);
        $a=Accept::where('id',$id)->where('pharmacy_id',$r['pharmacy_id'])->first();
        $a->number=$r['number'];
        $a->updated_by=10;
        $a->update();

        return redirect()->route('accept.med.show',['id'=>$a->pharmacy_id]);
    }



    public function stock()
    {
        $id=Session::get('user')->id;
        $medicines=Medicine::all();
        $pharmacies=DB::table('tg_pharm_users')
            ->where('user_id',$id)
            ->selectRaw('user_id, pharmacy_id, tg_pharmacy.name as name, tg_pharmacy.region as region,tg_pharmacy.slug as slug')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_pharm_users.pharmacy_id')
            ->get();

        return view('stockProduct.create',compact('id','medicines','pharmacies'));
    }

    public function store2(Request $request)
    {
        $request->validate([
            'created_by'=>'required',
            'pharmacy_id'=>'required'
        ]);

        $r=$request->all();
        unset($r['_token']);
        $created_by=$r['created_by'];
        $pharmacy_id=$r['pharmacy_id'];
        foreach ($r as $key=>$item){
            if($item!=null &&$key!='created_by'&&$key!='pharmacy_id' ){
                $accept =new Stock();
                $accept->medicine_id=substr($key,3);
                $accept->number=$item;
                $accept->created_by=$created_by;
                $accept->updated_by=$created_by;
                $accept->pharmacy_id=$pharmacy_id;
                $accept->save();
            }
        }
        return redirect()->back();
    }
}
