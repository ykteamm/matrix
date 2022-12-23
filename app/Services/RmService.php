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
    public $day;
    public function users()
    {
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime(date_now())))
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();
        return $users;
    }
    public function usersT()
    {
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-1 day',strtotime(date_now()))))
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();
            
        return $users;
    }
    public function pharmacy()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime(date_now())))
                    ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_pharmacy.id')->get();
        return $pharmacy;
    }
    public function pharmacyT()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-1 day',strtotime(date_now()))))
                    ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_pharmacy.id')->get();
        return $pharmacy;
    }
    public function medicine()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id,tg_medicine.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime(date_now())))
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_medicine.id')->get();
        return $pharmacy;
    }
    public function medicineT()
    {
        $pharmacy = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id,tg_medicine.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-1 day',strtotime(date_now()))))
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_medicine.id')->get();
        return $pharmacy;
    }
    public function allUsers($time,$region_id)
    {
        $date = new ElchiService;
        $date = $date->day($time);
        $userRegion = getUserRegion();
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.id',$userRegion)
            ->whereIn('tg_user.region_id',$region_id)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();
        return $users;
    }
    public function allPharmacy($time,$region_id)
    {
        $date = new ElchiService;
        $date = $date->day($time);
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.region_id',$region_id)
            ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_pharmacy.id')->get();
        return $users;
    }
    public function allMedicine($time,$region_id)
    {
        $date = new ElchiService;
        $date = $date->day($time);
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id,tg_medicine.name')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.region_id',$region_id)
            ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_medicine.id')->get();
        return $users;
    }
    
}
