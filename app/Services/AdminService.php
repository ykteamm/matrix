<?php

namespace App\Services;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\ProductSold;
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
                ->whereDate('created_at','>=',$this->startOfWeek())
                ->whereDate('created_at','<=',$this->endOfWeek())
                ->sum(DB::raw('price*quantity'));

                $s += $mc_del - $mc_del*$value->discount/100;
            }
            
            return $s;
    }

    public function rek()
    {
        $last_30 = date('Y-m-d',strtotime('-31 day',strtotime(date('Y-m-d'))));

        $pharmacy_sold = ProductSold::whereDate('created_at','<=',date('Y-m-d'))
        ->whereDate('created_at','>=',$last_30)
        ->distinct('pharm_id')->pluck('pharm_id')->toArray();

        $pharmacy_sold = array_filter($pharmacy_sold, function($a) {
            return trim($a) !== "";
        });

        $pharmacy_elchi_order = [];
        
        foreach ($pharmacy_sold as $key => $value) {
            
            $rek_service = new RekServices($value);

            $con = $rek_service->getConditionPharmacy();
            $satisday = $rek_service->getSatisDay();
            $sum = $rek_service->getRekSum($satisday,$con);
            
            $pharmacy_elchi_order[] = array('con' => $con,'sum' => $sum);

        }

        return $pharmacy_elchi_order;

    }

    public function qarz()
    {
        $qizil_soni = 0;
        $qizil_sumi = 0;

        $sariq_soni = 0;
        $sariq_sumi = 0;

        $yashil_soni = 0;
        $yashil_sumi = 0;

        $qizil_id = [];
        $sariq_id = [];
        $yashil_id = [];

        $orders = McOrder::all();

        foreach ($orders as $key => $order) {

            $tovar = McOrderDetail::where('order_id',$order->id)->orderBy('id','ASC')->first();
            $qarz = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();
            
            if($tovar)
            {
                $order_date = $order->order_date;

                $day = strtotime(date('Y-m-d'))-strtotime($order_date);

                $delivery_sum = McOrderDelivery::where('order_id',$order->id)
                        ->sum(DB::raw('quantity*price'));

                $delivery = $delivery_sum - $delivery_sum*$order->discount/100;

                $pul = McPaymentHistory::where('order_id',$order->id)->sum('amount');

                if($qarz)
                {
                    if($pul == $delivery)
                    {
                        $yashil_soni += 1;
                        $yashil_sumi += $delivery;
                        $yashil_id[] = $order->id;
                    }else{
                        $sariq_soni += 1;
                        $sariq_sumi += $delivery;
                        $sariq_id[] = $order->id;
                    }
                }else{
                    if($order->discount == 30 && $day > 6)
                    {
                        $qizil_soni += 1;
                        $qizil_sumi += $delivery;
                        $qizil_id[] = $order->id;
                    }elseif($order->discount == 30 && $day < 6)
                    {
                        $sariq_soni += 1;
                        $sariq_sumi += $delivery;
                        $sariq_id[] = $order->id;
                    }
                    elseif($order->discount == 15 && $day > 8)
                    {
                        $qizil_soni += 1;
                        $qizil_sumi += $delivery;
                        $qizil_id[] = $order->id;
                    }
                    elseif($order->discount == 15 && $day < 8)
                    {
                        $sariq_soni += 1;
                        $sariq_sumi += $delivery;
                        $sariq_id[] = $order->id;
                    }
                    elseif($order->discount == 10 && $day > 11)
                    {
                        $qizil_soni += 1;
                        $qizil_sumi += $delivery;
                        $qizil_id[] = $order->id;

                    }elseif($order->discount == 10 && $day < 11)
                    {
                        $sariq_soni += 1;
                        $sariq_sumi += $delivery;
                        $sariq_id[] = $order->id;
                    }
                    else{
                        $qizil_soni += 1;
                        $qizil_sumi += $delivery;
                        $qizil_id[] = $order->id;
                    }
                }
                

                
            }

        }

        return [
            'qizil_soni' => $qizil_soni,
            'qizil_sumi' => $qizil_sumi,
            'qizil_id' => $qizil_id,
            'sariq_soni' => $sariq_soni,
            'sariq_sumi' => $sariq_sumi,
            'sariq_id' => $sariq_id,
            'yashil_soni' => $yashil_soni,
            'yashil_sumi' => $yashil_sumi,
            'yashil_id' => $yashil_id,
        ];
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
