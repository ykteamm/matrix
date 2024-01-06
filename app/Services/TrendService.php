<?php

namespace App\Services;

use App\Items\TrendRangeItems;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrendService
{
    public function range2($range)
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
    public function range($range)
    {
        if($range == 'three')
        {
            $date_count = 3;
        }
        if($range == 'six')
        {
            $date_count = 6;
        }
        if($range == 'twelve')
        {
            $date_count = 12;
        }
        $date_begin = date_now()->format('Y-m-d');
        $date_array=[];
        for ($i=0; $i < $date_count ; $i++) {
            $firstDate = Carbon::createFromFormat('Y-m-d', $date_begin)
                ->firstOfMonth()
                ->format('Y-m-d');

            $date_first = date('Y-m-d',(strtotime ( '-'.$i.' month' , strtotime ( $firstDate) ) ));
            $date_array[]=$date_first;


            if($i==0)
            {
//                $firstDate = $date_begin;
            }else{
                $firstDate = Carbon::createFromFormat('Y-m-d', $date_first)
                ->endOfMonth()
                ->format('Y-m-d');
            }

            //$date_array[]=$firstDate;
        }
        sort($date_array);

        return $date_array;

    }

    public function test($range){
        if ($range == 'three') {
            $date_count = 3;
        }
        if ($range == 'six') {
            $date_count = 6;
        }
        if ($range == 'twelve') {
            $date_count = 12;
        }

        $date_begin = now()->format('Y-m-d');
        $date_array = [];

        for ($i = 0; $i <= $date_count; $i++) {
            $firstDate = Carbon::createFromFormat('Y-m-d', $date_begin)
                ->subMonths($i)
                ->firstOfMonth()
                ->format('Y-m-d');

            $date_last = Carbon::createFromFormat('Y-m-d', $date_begin)
                ->subMonths($i - 1)
                ->endOfMonth()
                ->format('Y-m-d');

            $date_array[] = $firstDate;
//            $date_array[] = $date_last;
        }

        sort($date_array);

        return $date_array;
    }

    public function format($date_array)
    {
        $format_date=[];
        foreach ($date_array as $key => $value) {
            $format_date[] = date('d.m.Y',(strtotime (  $value ) ));
        }
        return $format_date;
    }
}
