<?php

namespace App\Services;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public $month_start;
    public $month_end;
    public $last_month_start;

    public function __construct()
    {
        $this->month_start = date('Y-m-'.'01');
        $this->month_end = $this->getLastDate($this->month_start);
        $this->last_month_start = $this->getFirstDate(date('Y-m-d',strtotime('-10 day',strtotime($this->month_start))));
    }

    public function arriveMoney()
    {

        $all_order_ids = McOrder::whereDate('order_date','<=',$this->month_end)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach($all_order_ids as $value)
            {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();

                $sum = McPaymentHistory::where('order_id',$value)
                ->whereDate('created_at','<=',$this->month_end)
                ->whereDate('created_at','>=',$this->month_start)
                ->sum('amount');
               
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $sum1 += $sum;
                        }else{
                            if(strtotime($ord_sum->created_at) < strtotime($this->month_start))
                            {
                                $sum1 += $sum;
                            }
                        }
                    }else{
                        $sum1 += $sum;
                    }
                    
                }
                
            }

            return $sum1;
    }

    public function arriveMoneyToday()
    {

        $all_order_ids = McOrder::whereDate('order_date','<=',$this->month_end)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach($all_order_ids as $value)
            {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();

                $sum = McPaymentHistory::where('order_id',$value)
                ->whereDate('created_at','=',$this->month_start)
                ->sum('amount');
               
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $sum1 += $sum;
                        }else{
                            if(strtotime($ord_sum->created_at) == strtotime($this->month_start))
                            {
                                $sum1 += $sum;
                            }
                        }
                    }else{
                        $sum1 += $sum;
                    }
                    
                }
                
            }

            return $sum1;
    }

    public function arriveMoneyWeek()
    {

        $all_order_ids = McOrder::whereDate('order_date','<=',$this->month_end)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach($all_order_ids as $value)
            {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();

                $sum = McPaymentHistory::where('order_id',$value)
                ->whereDate('created_at','>=',$this->startOfWeek())
                ->whereDate('created_at','<=',$this->endOfWeek())
                ->sum('amount');
               
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $sum1 += $sum;
                        }else{
                            if(strtotime($ord_sum->created_at) >= strtotime($this->startOfWeek()) && strtotime($ord_sum->created_at) >= strtotime($this->startOfWeek()))
                            {
                                $sum1 += $sum;
                            }
                        }
                    }else{
                        $sum1 += $sum;
                    }
                    
                }
                
            }

            return $sum1;
    }

    public function shipment()
    {
        $ords = McOrder::whereDate('order_date','<=',$this->month_end)
            ->get();
            $s = 0;
            foreach ($ords as $key => $value) {
                $mc_del = McOrderDelivery::where('order_id',$value->id)
                ->whereDate('created_at','>=',$this->month_start)
                ->whereDate('created_at','<=',$this->month_end)
                ->sum(DB::raw('price*quantity'));

                $s += $mc_del - $mc_del*$value->discount/100;
            }
            
            return $s;
    }

    public function shipmentDay()
    {
        $ords = McOrder::whereDate('order_date','<=',$this->month_end)
            ->get();
            $s = 0;
            foreach ($ords as $key => $value) {
                $mc_del = McOrderDelivery::where('order_id',$value->id)
                ->whereDate('created_at','=',$this->month_start)
                ->sum(DB::raw('price*quantity'));

                $s += $mc_del - $mc_del*$value->discount/100;
            }
            
            return $s;
    }

    public function shipmentWeek()
    {
        $ords = McOrder::whereDate('order_date','<=',$this->month_end)
            ->get();
            $s = 0;
            foreach ($ords as $key => $value) {
                $mc_del = McOrderDelivery::where('order_id',$value->id)
                ->whereDate('created_at','>=',$this->month_start)
                ->whereDate('created_at','<=',$this->month_end)
                ->sum(DB::raw('price*quantity'));

                $s += $mc_del - $mc_del*$value->discount/100;
            }
            
            return $s;
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

    public function startOfWeek()
    {
        return  Carbon::now()->startOfWeek()->format('Y-m-d');
    }

    public function endOfWeek()
    {
        return  Carbon::now()->endOfWeek()->format('Y-m-d');
    }
}
