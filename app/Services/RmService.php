<?php

namespace App\Services;

use App\Items\DateTextItems;
use App\Models\Calendar;
use App\Models\Plan;
use App\Models\PlanWeek;
use Carbon\Carbon;
use App\Services\ElchiService;
use Illuminate\Support\Facades\DB;

class RmService
{
    public $day = 5;
    public function users($date = null)
    {
        if($date)
        {
            $time = new ElchiService;
            $dates = $time->day($date);
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','>=',$dates->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$dates->date_end)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();
            $dateText = $dates->dateText;
        }else{
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-'.$this->day.' day',strtotime(date_now()))))
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();
            $dateText = 'Bugunr';
        }
        $item = new DateTextItems();
        $item->users=$users;
        $item->dateText=$dateText;  
        return $item;
    }
    public function pharmacy()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-'.$this->day.' day',strtotime(date_now()))))
                    ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_pharmacy.id')->get();
        return $pharmacy;
    }
    public function medicine()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id,tg_medicine.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-'.$this->day.' day',strtotime(date_now()))))
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_medicine.id')->get();
        return $pharmacy;
    }
}
