<?php

namespace App\Http\Controllers;

use App\Models\CategoryMedicine;
use App\Services\TrendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Pharmacy;
use Carbon\Carbon;

class TrendController extends Controller
{
    public $service;

    public function __construct(TrendService $service)
    {
        $this->service=$service;
    }

    public function trend()
    {
        $region = Region::all();

        return view('trend.trend',compact('region'));
    }


    public function RegionStatistic(Request $request)
    {
        $region_id = $request->region_id;
        $regions = Region::orderBy('id','ASC')->where('id',$region_id)->first();
        $users = User::where('region_id',$region_id)
            ->where('specialty_id',1)->pluck('id')->toArray();

            $users = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,
                tg_user.id,
                tg_user.first_name,
                tg_user.last_name')
                ->whereDate('tg_productssold.created_at','>=','2023-01-01')
                ->whereDate('tg_productssold.created_at','<=','2023-12-31')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->whereIn('tg_user.id',$users)
                ->orderBy('allprice','DESC')
                ->groupBy('tg_user.id')
                ->get();
        $user_data = User::where('region_id',$region_id)
            ->where('specialty_id',1)->get();

        $date=[];
//yan
        $date[] = [
            '2023-01-01',
            '2023-01-31',
        ];
//fev
        $date[] = [
            '2023-02-01',
            '2023-02-28',
        ];
//mart
        $date[] = [
            '2023-03-01',
            '2023-03-31',
        ];
//aprel
        $date[] = [
            '2023-04-01',
            '2023-04-30',
        ];
//may
        $date[] = [
            '2023-05-01',
            '2023-05-31',
        ];
//iyun
        $date[] = [
            '2023-06-01',
            '2023-06-30',
        ];
// iyul
        $date[] = [
            '2023-07-01',
            '2023-07-31',
        ];
//        avg
        $date[] = [
            '2023-08-01',
            '2023-08-31',
        ];
//        sen
        $date[] = [
            '2023-09-01',
            '2023-09-30',
        ];
//        okt
        $date[] = [
            '2023-10-01',
            '2023-10-31',
        ];
//        noyabr
        $date[] = [
            '2023-11-01',
            '2023-11-30',
        ];
//        dekabr
        $date[] = [
            '2023-12-01',
            '2023-12-31',
        ];
//        2024 yan
//        $date[] = [
//            '2024-01-01',
//            '2024-01-31',
//        ];

        $json = [];

            foreach($users as  $user)
            {
                $date_array = [];
                foreach ( $date as $d)
                {
                    $region_chart = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                        ->whereDate('tg_productssold.created_at','>=',$d[0])
                        ->whereDate('tg_productssold.created_at','<=',$d[1])
                        ->where('user_id','=',$user->id)->get();

                    $json[$user->id][] =
                    [
                        'month' => $d[0],
                        'allprice' => $region_chart[0]->allprice ?? 0,
                    ];
                    $date_array[] = $d[0];
                }
            }
//           return $date_array;
//return $user_data;
//            return $users;
//    return $json;

        return view('trend.region_statistic',compact('json','date_array','regions','users','user_data'));
    }

    public function RegionStatistic2(Request $request)
    {
        $region_id = $request->region_id;
        $range = 'twelve';
        $date_array = $this->service->test($range);
        unset($date_array[12]);
//        return $date_array;
        $json = array();
        $regions = Region::orderBy('id','ASC')->where('id',$region_id)->first();
        $users = User::where('region_id',$region_id)
            ->where('specialty_id',1)->get();
        $startDate = '01-01-2023';
        $endDate = '01-01-2024';



        foreach($users as  $user)
        {
            $region_chart = DB::table('tg_productssold')
                ->selectRaw(
                    'SUM(tg_productssold.number * tg_productssold.price_product) as allprice,
                       tg_region.id as region_id,
                        TO_CHAR(tg_productssold.created_at, \'YYYY-Mon\') as month,
                        tg_user.username,
                        tg_user.first_name,
                        tg_user.last_name,
                        tg_user.id
                        '
                )
//                    ->whereDate('tg_productssold.created_at','=',$date)
                ->whereBetween('tg_productssold.created_at', [$startDate, $endDate])
                ->where('tg_region.id','=',$regions->id)
                ->where('tg_user.id','=',$user->id)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->orderByRaw('MIN(tg_productssold.created_at) ASC')
                ->groupBy('tg_region.id','month','tg_user.username', 'tg_user.first_name','tg_user.id','tg_user.last_name')->get();

//                return $region_chart;

            // Massivga ma'lumotni qo'shamiz
            foreach ($region_chart as $chart) {
//                        $formattedMonth = Carbon::createFromFormat('Y-M', $chart->month)->format('d.m.Y');
                $formattedMonth = Carbon::createFromFormat('Y-M', $chart->month)->firstOfMonth()->format('d.m.Y');
                // If there is data available for the current medicine, add it to the $medicinesData array
                $json[$chart->id][] = [
                    'month' => $formattedMonth,
                    'firstname' => $chart->first_name,
                    'lastname' => $chart->last_name,
                    'id' => $chart->id,
                    'allprice' => $chart->allprice,
                ];
            }
//
        }
        $date_array = $this->service->format($date_array);
//        return $date_array;

        return view('trend.region_statistic',compact('json','date_array','regions','users'));
    }
    public function region($range)
    {

        $date_array = $this->service->range($range);
        $json = array();
        $regions = Region::orderBy('id','ASC')->get();
        foreach($date_array as $key => $date)
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
        $date_array = $this->service->format($date_array);

        return view('trend.region',compact('json','date_array','regions'));
    }

    public function ProductStatistic(Request $request)
    {
        $range = 'twelve';
        $region_id = $request->region_id;
        $date_array = $this->service->test($range);
        $json = array();
        $regionID = Region::orderBy('id','ASC')->where('id',$region_id)->first();
        $medicine = Medicine::where('id','<=',60)->orderBy('id','ASC')->get();
        $category = CategoryMedicine::orderBy('id','asc')->get();
        $startDate = '01-01-2023';
        $endDate = '01-01-2024';
        foreach ($category as $cate){
            foreach($date_array as $date)
            {
                $medicinesData = [];
//                return $date_array;
                foreach($medicine as $key => $med)
                {
//                    return $med;
                    $region_chart = DB::table('tg_productssold')
                        ->selectRaw(
                            'SUM(tg_productssold.number * tg_productssold.price_product) as allprice,
                        tg_medicine.id as med_id,tg_region.id as region_id,tg_medicine.category_id,
                        TO_CHAR(tg_productssold.created_at, \'YYYY-Mon\') as month')
//                        ->whereDate('tg_productssold.created_at','=',$date)
                        ->whereBetween('tg_productssold.created_at', [$startDate, $endDate])
//                        ->whereIn(DB::raw('DATE_FORMAT(tg_productssold.created_at, "%Y-%m-%d")'), $date_array)
                        ->where('tg_region.id','=',$region_id)
                        ->where('tg_medicine.id','=',$med->id)
                        ->where('tg_medicine.category_id','=',$cate->id)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->join('tg_region','tg_region.id','tg_user.region_id')
                        ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
//                        ->orderBy('month','ASC')
                        ->orderByRaw('MIN(tg_productssold.created_at) ASC')
                        ->groupBy('med_id','tg_region.id','tg_medicine.category_id','month')->get();
//                    return $region_chart;

                    foreach ($region_chart as $chart) {
//                        $formattedMonth = Carbon::createFromFormat('Y-M', $chart->month)->format('d.m.Y');
                        $formattedMonth = Carbon::createFromFormat('Y-M', $chart->month)->firstOfMonth()->format('d.m.Y');

                        // If there is data available for the current medicine, add it to the $medicinesData array
                        $medicinesData[$chart->med_id][] = [
                            'month' => $formattedMonth,
                            'allprice' => $chart->allprice,
                        ];
                    }
//                    return $region_chart;
//                    if(isset($region_chart->allprice))
//                    {
//                        $json[$med->id][] = $region_chart->allprice;
//                    }
//                    else{
//                        $json[$med->id][] = 0;
//                    }
//                    return $json;
                }
                $json[$cate->id] = $medicinesData;
            }
        }
//        return $json;
        $date_array = $this->service->format($date_array);
//        return $date_array;

//        return $region_chart;
//       return $json;

        return view('trend.product_statistic',compact('json','date_array','medicine','regionID','category'));
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
        $date_array = $this->service->format($date_array);

        return view('trend.product',compact('json','date_array','regions'));
    }

    public function MonthStatistic()
    {

        return view('trend.month_statistic');
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
        $date_array = $this->service->format($date_array);

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
        $date_array = $this->service->format($date_array);

        return view('trend.pharmacy',compact('json','date_array','regions'));
    }
}
