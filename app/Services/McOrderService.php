<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\Pharmacy;
use App\Models\Plan;
use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class McOrderService
{
    public $type;
    public $outer_type;
    public $pharmacy_or_user;

    public function __construct($type)
    {
        $this->type = $type;

        $this->selectUserOrPharmacy();
    }

    public function selectUserOrPharmacy()
    {
        $region_id = $this->getSpecialRegionId();
        if($this->type == 1)
        {
            $pharmacy_or_user = Pharmacy::with('region')->whereIn('region_id',$region_id)->get();

            

            $outer = 1;

        }else{

            $pharmacy_or_user = User::whereIn('region_id',$region_id)->get();
            $outer = 2;
        }

        $this->pharmacy_or_user = $pharmacy_or_user;
        $this->outer_type = $outer;
    }

    public  function getOuterType()
    {
        return $this->outer_type;
    }

    public function getPharmacyOrUser()
    {
        return $this->pharmacy_or_user;
    }

    public function saveOrderData()
    {

    }

    public function foiz($array)
    {
       $sum = array_sum($array);

       if($sum < 5000000)
       {
            $skidka = 0;
       }elseif($sum >= 5000000 && $sum < 10000000)
       {
            $skidka = 5;
       }
       elseif($sum >= 10000000 && $sum < 15000000)
       {
            $skidka = 10;
       }else{
            $skidka = 15;
       }
       return $skidka;
    }

    public function getSpecialRegionId()
    {
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $r_id_array = DB::table('tg_region')->pluck('id')->toArray();
            }else{
                $r_id_array = [];
                foreach (Session::get('per') as $key => $value) {
                    if (is_numeric($key)){
                $r_id_array[] = $key;
                    }
                }

            }

        return $r_id_array;
    }
}
