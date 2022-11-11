<?php

namespace App\Http\Controllers;

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

        $stocks=Stock::whereDate('created_at','<=',$time)
            ->with('medicine')->get();
        $pharm=Pharmacy::where('id',$pharmacy_id)->first();
        $pharmacy=DB::table('tg_accepts')
            ->selectRaw('SUM(tg_accepts.number) as amount,medicine_id,pharmacy_id, tg_medicine.name as name,tg_pharmacy.name as pharmacy_name')
            ->whereDate('tg_accepts.created_at','<=',$time)
            ->join('tg_pharmacy','tg_pharmacy.id','tg_accepts.pharmacy_id')
            ->join('tg_medicine','tg_medicine.id','tg_accepts.medicine_id')
//            ->join('tg_productssold','tg_productssold.pharmacy_id','tg_pharmacy.id')
            ->groupBy('pharmacy_id','medicine_id','tg_medicine.name','tg_pharmacy.name')->get();


//    dd($pharmacy);
        return view('compare.show',compact('pharmacy_id','pharm','pharmacy','stocks'));
    }
}
