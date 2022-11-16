<?php

namespace App\Http\Controllers;

use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Services\ElchilarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElchilarController extends Controller
{
    public $service;
    public function __construct(ElchilarService $service)
    {
        $this->service=$service;
    }

    public function kunlik($month)
    {
        $cale = DB::table('tg_calendar')->where('year_month',date('m.Y',strtotime($month)))->first();
        if ($cale==null){
            return " Kalendarda ".$month." kiritilmagan";
        }
        $years=[2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030,2031,2032];
        $months=$this->service->month();
        $endofmonth=$this->service->endmonth($month,$months);
        $data=$this->service->elchilar($month,$endofmonth);
        $elchi=$data->elchi;
        $elchi_work=$data->elchi_work;
        $elchi_fact=$data->elchi_fact;
        $elchi_prognoz=$data->elchi_prognoz;
        $plan=$this->service->plan($elchi,$month,$endofmonth);
        $plan_day=$this->service->planday($elchi,$month,$endofmonth);
        $encane=$this->service->encane($elchi);
        $days=$this->service->checkCalendar($month,$endofmonth);
        $sold=$this->service->sold($elchi,$days,$month,$endofmonth);
        $elchilar=$this->service->reyting($elchi);
        $haftalik=$this->service->haftalik($days,$sold,$elchilar);
        $viloyatlar=$this->service->viloyatlar();
//        dd($viloyatlar[0]->name);

//        dd($haftalik);
        return view('elchilar.index',compact('viloyatlar','years','endofmonth','month','elchi_prognoz','months','elchilar','elchi_work','elchi_fact','plan','plan_day','encane','days','sold','haftalik','viloyatlar'));
    }
}
