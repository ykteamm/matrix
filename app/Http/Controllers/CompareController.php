<?php

namespace App\Http\Controllers;

use App\Models\Accept;
use App\Models\Calendar;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Models\Shift;
use App\Models\Stock;
use App\Models\User;
use App\Services\ElchilarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    public function index()
    {
        $date_begin = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));

        $shift_pharm = Shift::selectRaw('count(pharma_id) as ids,pharma_id')
        ->whereDate('created_at','>=',$date_begin)
        ->whereDate('created_at','<=',date('Y-m-d'))
        ->groupBy('pharma_id')
        ->get();

        $pharmacy = [];

        foreach ($shift_pharm as $key => $value) {
            if($value->ids > 3)
            {
                $date = Stock::where('pharmacy_id',$value->pharma_id)->orderBy('id','DESC')->first();
                $pharmacy[] = array('pharmacy' => Pharmacy::find($value->pharma_id),'ostatok' => $date);

            }
        }

        return view('compare.index',compact('pharmacy'));
    }

    public function show($pharmacy_id,$month)
    {
        $ser=new ElchilarService();
        $months=$ser->month();

        $endofmonth=$ser->endmonth($month,$months);

        $last_month = date('Y-m',strtotime('-1 month',strtotime($month)));
        $endof_last_month=$ser->endmonth($last_month,$months);

        $months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');


        $medicine = Medicine::with(['pricem' => function($q) {
            $q->where('shablon_id', 3);

        }])->orderBy('id')->get();
        $accept = 0;

        $month_date=Stock::where('pharmacy_id',$pharmacy_id)
            ->whereDate('date','>=',date('Y-m',strtotime($month)).'-01')
            ->whereDate('date','<=',date('Y-m',strtotime($month)).'-'.$endofmonth)
            ->distinct('date_time')->pluck('date_time')->toArray();

        $count_date = count($month_date);

        $last_month_date=Stock::where('pharmacy_id',$pharmacy_id)
        ->whereDate('date','<=',date('Y-m',strtotime($last_month)).'-'.$endof_last_month)
        ->orderBy('id','DESC')->first();
        if($last_month_date)
        {
            array_unshift($month_date,$last_month_date->date_time);
        }

        $count = count($month_date);

        $dates = [];
        $solds = [];
        $accepts = [];
        $rm_prixod = [];
        $first_stocks = [];
        $second_stocks = [];
        $stocks = [];

        for ($i=0; $i < $count-1; $i++) {
            $dates[$i][] = $month_date[$i];
            $dates[$i][] = $month_date[$i+1];

        }

        if($last_month_date)
        {
            $dates[count($dates)][] = $last_month_date->date_time;
            $dates[count($dates)-1][] = $month_date[count($month_date)-1];
        }



            foreach ($dates as $key => $value) {
                foreach($medicine as $m)
                {
                    $sold=DB::table('tg_productssold')->where('pharm_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$value[0])
                    ->whereDate('created_at','<=',$value[1])
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $solds[$key][$m->id] = $sold;


                    $pharmacy_ids = McOrder::where('pharmacy_id',$pharmacy_id)->pluck('id')->toArray();

                    $accept = McOrderDelivery::whereIn('order_id',$pharmacy_ids)
                    ->whereDate('created_at','>=',$value[0])
                    ->whereDate('created_at','<=',$value[1])
                    ->where('product_id',$m->id)
                    ->sum('quantity');

                    $accepts[$key][$m->id] = $accept;


                    $rm = Accept::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('created_at','>=',$value[0])
                    ->whereDate('created_at','<=',$value[1])
                    ->where('medicine_id',$m->id)
                    ->sum('number');

                    $rm_prixod[$key][$m->id] = $rm;


                    $stock1 = Stock::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('date','=',date('Y-m-d',strtotime($value[0])))
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $first_stocks[$key][$m->id] = $stock1;

                    $stock2 = Stock::where('pharmacy_id',$pharmacy_id)
                    ->whereDate('date','=',date('Y-m-d',strtotime($value[1])))
                    ->where('medicine_id',$m->id)
                    ->sum('number');
                    $second_stocks[$key][$m->id] = $stock2;
                }

            }



        $pharm=Pharmacy::where('id',$pharmacy_id)->first('name');


        return view('compare.show',compact('rm_prixod','count_date','dates','accepts','first_stocks','second_stocks','solds','medicine','pharm','months','month','pharmacy_id'));

    }

    public function everyday($id)
    {
        if($id == 25022024)
        {
            $users = User::all();

            foreach($users as $user)
            {
                $u = User::find($user->id);
                $pr = $u->pr + 1;

                DB::table('tg_user')->where('id',$user->id)->update([
                    'pr' => $pr
                ]);
            }
        }

        if($id == 20240225)
        {
           $users = User::all();

            foreach($users as $user)
                {
                    $u = User::find($user->id);
                    $pr = $u->pr - 1;

                    DB::table('tg_user')->where('id',$user->id)->update([
                        'pr' => $pr
                    ]);
                }
        }

        $users = User::orderBy('id','DESC')->pluck('pr','username')->toArray();


        return $users;
    }

    public function getLastDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        return $d;
    }
}
