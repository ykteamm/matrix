<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Medicine;
use App\Models\PharmUser;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AcceptProductController extends Controller
{
    public function index()
    {
        $id=Session::get('user')->id;

        $medicines=Medicine::all();
        $pharmacies=DB::table('tg_pharm_users')
            ->where('user_id',$id)
            ->selectRaw('user_id, pharmacy_id, tg_pharmacy.name as name, tg_pharmacy.region as region,tg_pharmacy.slug as slug')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_pharm_users.pharmacy_id')
            ->get();
//        dd($pharmacies);
        return view('acceptProduct.index',compact('id','medicines','pharmacies'));
    }

    public function store(Request $request)
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
               $accept =new Accept();
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

    public function stock()
    {
        $id=Session::get('user')->id;
        $medicines=Medicine::all();
        $pharmacies=DB::table('tg_pharm_users')
            ->where('user_id',$id)
            ->selectRaw('user_id, pharmacy_id, tg_pharmacy.name as name, tg_pharmacy.region as region,tg_pharmacy.slug as slug')
            ->join('tg_pharmacy','tg_pharmacy.id','tg_pharm_users.pharmacy_id')
            ->get();

        return view('acceptProduct.index',compact('id','medicines','pharmacies'));
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
