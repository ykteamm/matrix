<?php

namespace App\Http\Controllers;

use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Services\ElchilarService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ElchilarController extends Controller
{
    public $service;
    public function __construct(ElchilarService $service)
    {
        $this->service = $service;
    }

    public function kunlik(Request $request, $month)
    {

        // $shift = DB::table('tg_shift')
        // // ->where('tg_shift.open_date','!=',null)
        // ->where('tg_shift.user_id',163)
        // ->whereDate('tg_shift.created_at','>=','2023-07-01')
        // ->whereDate('tg_shift.created_at','<','2023-07-31')
        // ->get();
        // dd($shift);
        $all_or_new = $request->input('all_or_new') ?? 'all';
        $side = $request->input('side') ?? 'all';
        $region = $request->input('region');
        $calendars = DB::table('tg_calendar')->orderBy('id','ASC')->pluck('year_month');
        if (isset($region)) {
            if ($region == 'all') {
                $regions = 1;
                $test = 1;
                $vil = 1;
            } else {
                $regions = explode(",", $region);
                $vil = DB::table('tg_region')->whereIn('id', $regions)->pluck('name');
                $test = 0;
            }
        } else {
            $regions = 0;
            $test = 1;
            $vil = 1;
        }

        $cale = DB::table('tg_calendar')->where('year_month', date('m.Y', strtotime($month)))->first();
        if ($cale == null) {
            return " Kalendarda " . $month . " kiritilmagan";
        }
        $years = [2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030, 2031, 2032];
        $months = $this->service->month();
        $endofmonth = $this->service->endmonth($month, $months);
        $user_id = Session::get('user')->id;
        $data = $this->service->elchilar($month, $endofmonth, $user_id, $regions, $all_or_new, $side);
        $elchi = $data->elchi;
        // return $elchi;
        $elchi_fact = $data->elchi_fact;
        $average = $data->average;

        $asd = [];

        foreach ($average as $key => $value) {
            if($value != 0)
            {
                $asd[] = $value;
            }
        }
        
        $average_array = round(array_sum($asd)/count($asd));

        $elchi_prognoz = $data->elchi_prognoz;
        $king_sold = $data->king_sold;
        $king_sold_month = $data->king_sold_month;
        $best_month = $data->best_month;
        $all_best_month = $data->all_best_month;
        $day_work = $data->all_work_day;
        // dd($elchi, $elchi_fact[$elchi[0]->id]);
        $item = $this->service->plan($elchi, $month, $endofmonth);

        $plan = $item->plan;

        $plan_day = $item->planday;
        $encane = $this->service->encane($elchi, $month);
        $days = $this->service->checkCalendar($month, $endofmonth);
        $sold = $this->service->sold($elchi, $days);
        $haftalik = $this->service->haftalik($days, $sold, $elchi);
        $viloyatlar = $this->service->viloyatlar();
        $tot_sold_day = $this->service->day_sold($elchi, $days, $sold);
        $total_fact = $this->service->total_fact($elchi_fact);
        $total_prog = $this->service->total_prog($elchi_prognoz);
        $total_plan = $this->service->total_plan($plan);
        $total_planday = $this->service->total_planday($plan_day);
        $total_haftalik = $this->service->total_week($haftalik, $days, $month);
        
        if ($all_or_new == 'all' || $all_or_new == 'pro' || $all_or_new == 'new' || $all_or_new == 'elchi' || $all_or_new == 'elchi_all') {
            uasort($elchi, function ($a, $b) use ($elchi_fact) {
                if(!isset($elchi_fact[$a['id']]))
                {
                    $elchi_fact[$a['id']]=0;
                }
                if(!isset($elchi_fact[$b['id']]))
                {
                    $elchi_fact[$b['id']]=0;
                }
                
                return $elchi_fact[$a['id']] > $elchi_fact[$b['id']] ? -1 : 1;
                
            });
            $elchi = new Collection($elchi);
        }

        // return $sold;

        return view('elchilar.index', compact('average_array','average','all_best_month','all_or_new', 'side', 'region', 'day_work', 'king_sold','king_sold_month','best_month', 'calendars', 'test', 'vil', 'total_haftalik', 'total_fact', 'total_prog', 'total_plan', 'total_planday', 'viloyatlar', 'tot_sold_day', 'years', 'endofmonth', 'month', 'elchi_prognoz', 'months', 'elchi', 'elchi_fact', 'plan', 'plan_day', 'encane', 'days', 'sold', 'haftalik', 'viloyatlar'));
    }
}
