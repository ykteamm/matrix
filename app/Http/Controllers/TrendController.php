<?php

namespace App\Http\Controllers;

use App\Services\TrendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Pharmacy;

class TrendController extends Controller
{
    public $service;

    public function __construct(TrendService $service)
    {
        $this->service=$service;
    }
    public function region($range)
    {
        $date_array = $this->service->range($range);
        $json = array();
        $regions = Region::orderBy('id','ASC')->get();
        foreach($date_array as $date)
        {
            foreach($regions as $key => $region)
                {
                    $region_chart = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_region.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_region.id','=',$region->id)
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('tg_region.id','ASC')
                    ->groupBy('tg_region.id')->first();

                    if(isset($region_chart->allprice))
                    {
                    $json[$region->id][] = $region_chart->allprice;
                    }else{
                    $json[$region->id][] = 0;
                    }
                }
        }
        return view('trend.region',compact('json','date_array','regions'));
    }
    public function product($range)
    {
        $date_array = $this->service->range($range);
        $json = array();
        $regions = Medicine::where('id','<=',60)->orderBy('id','ASC')->get();
        foreach($date_array as $date)
        {
            foreach($regions as $key => $region)
                {
                    $region_chart = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_medicine.id','=',$region->id)
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->orderBy('tg_medicine.id','ASC')
                    ->groupBy('tg_medicine.id')->first();

                    if(isset($region_chart->allprice))
                    {
                    $json[$region->id][] = $region_chart->allprice;
                    }else{
                    $json[$region->id][] = 0;
                    }
                }
        }
        return view('trend.product',compact('json','date_array','regions'));
    }
    public function user($range)
    {
        $date_array = $this->service->range($range);
        $json = array();
        $regions = User::where('admin',FALSE)->orderBy('id','ASC')->get();
        foreach($date_array as $date)
        {
            foreach($regions as $key => $region)
                {
                    $region_chart = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_user.id','=',$region->id)
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->orderBy('tg_user.id','ASC')
                    ->groupBy('tg_user.id')->first();

                    if(isset($region_chart->allprice))
                    {
                    $json[$region->id][] = $region_chart->allprice;
                    }else{
                    $json[$region->id][] = 0;
                    }
                }
        }
        return view('trend.user',compact('json','date_array','regions'));
    }
    public function pharmacy($range)
    {
        $date_array = $this->service->range($range);
        $json = array();
        $regions = Pharmacy::orderBy('id','ASC')->get();
        foreach($date_array as $date)
        {
            foreach($regions as $key => $region)
                {
                    $region_chart = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_pharmacy.id','=',$region->id)
                    ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
                    ->orderBy('tg_pharmacy.id','ASC')
                    ->groupBy('tg_pharmacy.id')->first();

                    if(isset($region_chart->allprice))
                    {
                    $json[$region->id][] = $region_chart->allprice;
                    }else{
                    $json[$region->id][] = 0;
                    }
                }
        }
        return view('trend.pharmacy',compact('json','date_array','regions'));
    }
}
