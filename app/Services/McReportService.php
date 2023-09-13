<?php

namespace App\Services;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class McReportService
{

    public $last_money = [];
    public $new_close_money = [];
    public $last_accept_money = [];
    public $new_accept_money = [];
    public $predoplata = [];
    
    public $active_month;

    public $last_active_month;

    public $last_month;

    public function __construct($active_month)
    {
        $this->active_month = $active_month;

        $this->last_active_month = $this->getLastDate($active_month);

        $this->last_month = $this->getFirstDate(date('Y-m-d',strtotime('-1 month',strtotime($active_month))));

    }

    public function lastCloseMoney($region_id,$pharmacy_ids)
    {
        
        $order_ids = $this->lastMonthOrderIds($pharmacy_ids);

        $sum = 0;

        foreach ($order_ids as $key => $order) {

            $ord_sum = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

            if($ord_sum)
            {
     
                $sum += McPaymentHistory::where('order_id',$order->id)
                    ->where('last',0)
                    ->whereDate('created_at','>=',$this->active_month)
                    ->whereDate('created_at','<=',$this->last_active_month)
                    ->sum('amount');
   
            }

           
        }

        $this->last_money[$region_id] = $sum;

        return $this->last_money;
    }

    public function lastAcceptMoney($region_id,$pharmacy_ids)
    {
        
        $order_ids = $this->lastMonthOrderIds($pharmacy_ids);

        $sum = 0;

        foreach ($order_ids as $key => $order) {

                $ords = McOrderDelivery::where('order_id',$order->id)->first();

                if($ords)
                {

                    $money = McPaymentHistory::where('order_id',$order->id)->sum('amount');

                    $otgruzka = McOrderDelivery::where('order_id',$order->id)->sum(DB::raw('quantity*price'));

                    $otgruzka = $otgruzka - $otgruzka*$order->discount/100;

                    $vozvrat = McReturnHistory::where('order_id',$order->id)->sum('amount');

                }else{

                    $money = McPaymentHistory::where('order_id',$order->id)->sum('amount');

                    $otgruzka = $order->price - $order->price*$order->discount/100;

                    $vozvrat = McReturnHistory::where('order_id',$order->id)->sum('amount');
                }

                $sum += $otgruzka - $money - $vozvrat;

        }

        $this->last_accept_money[$region_id] = $sum;

        return $this->last_accept_money;
    }

    public function newCloseMoney($region_id,$pharmacy_ids)
    {
        
        $order_ids = $this->activeMonthOrderIds($pharmacy_ids);

        $order_ids_last = $this->lastMonthOrderIds($pharmacy_ids);

        $sum = 0;

        $sum1 = 0;

        foreach ($order_ids as $key => $order) {

            $ord_sum = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

            if($ord_sum)
            {
                $sum += McPaymentHistory::where('order_id',$order->id)
                    ->whereDate('created_at','>=',$this->active_month)
                    ->whereDate('created_at','<=',$this->last_active_month)
                    ->sum('amount');
            }

            
        }

        foreach ($order_ids_last as $key => $order) {

            $ord_sum = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

            if($ord_sum)
            {
                $sum1 += McPaymentHistory::where('order_id',$order->id)
                    ->where('last',1)
                    ->whereDate('created_at','>=',$this->active_month)
                    ->whereDate('created_at','<=',$this->last_active_month)
                    ->sum('amount');
            }
        }

        $this->new_close_money[$region_id] = $sum + $sum1;

        return $this->new_close_money;

    }

    public function newAcceptMoney($region_id,$pharmacy_ids)
    {
        
        $order_ids = $this->activeMonthOrderIds($pharmacy_ids);

        $sum = 0;

        foreach ($order_ids as $key => $order) {

            $ords = McOrderDelivery::where('order_id',$order->id)->first();

            if($ords)
            {

                $money = McPaymentHistory::where('order_id',$order->id)->sum('amount');

                $otgruzka = McOrderDelivery::where('order_id',$order->id)->sum(DB::raw('quantity*price'));

                $otgruzka = $otgruzka - $otgruzka*$order->discount/100;

                $vozvrat = McReturnHistory::where('order_id',$order->id)->sum('amount');

            }else{

                $money = McPaymentHistory::where('order_id',$order->id)->sum('amount');

                $otgruzka = $order->price - $order->price*$order->discount/100;

                $vozvrat = McReturnHistory::where('order_id',$order->id)->sum('amount');
            }

            $sum += $otgruzka - $money - $vozvrat;

        }

        $this->new_accept_money[$region_id] = $sum;

        return $this->new_accept_money;

    }

    public function predoplata($region_id,$pharmacy_ids)
    {
        $order_ids = $this->lastMonthOrderIds($pharmacy_ids);

        $sum = 0;

        foreach ($order_ids as $key => $order) {

            $ord_sum = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

            if($ord_sum)
            {
                if(strtotime($ord_sum->created_at) < strtotime($order->order_date))
                {
                    $sum += $ord_sum->amount;
                }
            }

           
        }

        $this->predoplata[$region_id] = $sum;

        return $this->predoplata;
    }

    public function lastMonthOrderIds($pharmacy_ids)
    {
        $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$this->active_month)
            ->orderBy('id','ASC')
            ->get();

        return $close_order_ids;
    }

    public function activeMonthOrderIds($pharmacy_ids)
    {
        $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$this->active_month)
            ->whereDate('order_date','<=',$this->last_active_month)
            ->get();

        return $new_order_ids;
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
