<?php

namespace App\Services;

use App\Items\TrendRangeItems;
use Illuminate\Support\Facades\DB;

class TrendService
{
    public function range($range)
    {
        if($range == 'three')
        {
            $date_begin = date_now()->format('d-m-Y');
            $date_end = date('d-m-Y',(strtotime ( '-3 month' , strtotime ( date_now()) ) ));
        }
        if($range == 'six')
        {
            $date_begin = date_now()->format('d-m-Y');
            $date_end = date('d-m-Y',(strtotime ( '-6 month' , strtotime ( date_now()) ) ));
        }
        $array = array();
        $Variable1 = strtotime($date_end);
        $Variable2 = strtotime($date_begin);
        for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
        {                        
        $Store = date('Y-m-d', $currentDate);
        $array[] = $Store;
        }
        return $array;
        
        // $items = new TrendRangeItems();
        // $items->date_begin = $date_begin;
        // $items->date_end = $date_end;
        // return $items;
    }
}
