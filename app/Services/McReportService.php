<?php

namespace App\Services;

use App\Models\McOrder;
use App\Models\McPaymentHistory;
use Carbon\Carbon;

class McReportService
{

    public $last_money = [];

    public $active_month;

    public $last_active_month;

    public $last_month;

    public function __construct($active_month)
    {
        $this->active_month = $active_month;

        $this->last_active_month = $this->getLastDate($active_month);

        $this->last_month = $this->getFirstDate(date('Y-m-d',strtotime('-1 month',strtotime($active_month))));

    }

    public function lastMoney($region_id,$pharmacy_ids)
    {
        
        $order_ids = $this->lastMonthOrderIds($pharmacy_ids);

        $sum = 0;

        $f = [];

        foreach ($order_ids as $key => $order) {

            $ord_sum = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

            if($ord_sum)
            {
                if(strtotime($order->order_date) > strtotime($ord_sum->created_at))
                    {
                        $sum += McPaymentHistory::where('order_id',$order->id)
                        // ->where('last',0)
                        ->whereDate('created_at','>=',$this->active_month)
                        ->whereDate('created_at','<=',$this->last_active_month)
                        ->sum('amount');
                        
                        

                    }else{

                        
                        $ff = McPaymentHistory::where('order_id',$order->id)
                        ->whereDate('created_at','>=',$this->active_month)
                        ->whereDate('created_at','<=',$this->last_active_month)
                        ->sum('amount');
            
                        $f[$order->id] = $ff;
                    }

                    
            }

           
        }

        dd($f);


        $this->last_money[$region_id] = $sum;

        return $this->last_money;
    }

    public function lastMonthOrderIds($pharmacy_ids)
    {
        $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$this->active_month)
            ->orderBy('id','ASC')
            ->get();

        return $close_order_ids;
    }

    public function getFirstDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->firstOfMonth()
                        ->format('Y-m-d');
        return $d;
    }

    public function getLastDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        return $d;
    }

}
