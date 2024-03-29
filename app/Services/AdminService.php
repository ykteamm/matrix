<?php

namespace App\Services;

use App\Models\McDeadlinePharmacy;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPayment;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public $month_start;
    public $month_end;
    public $last_month_start;
    public $regions;

    public function __construct()
    {
        $this->month_start = date('Y-m-'.'01');
        // $this->month_start = date('2023-08-01');
        $this->month_end = $this->getLastDate($this->month_start);
        $this->last_month_start = $this->getFirstDate(date('Y-m-d',strtotime('-10 day',strtotime($this->month_start))));
        $this->regions = Region::all();
    }

    public function arriveMoney33()
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
                            // if(strtotime($ord_sum->created_at) < strtotime($this->month_start))
                            // {
                                $sum1 += $sum;
                            // }
                        }
                    }else{
                        $sum1 += $sum;
                    }
                    
                }
                
            }

            dd($sum1);
    }

    public function arriveMoney()
    {
        $last_close_money = [];
        $new_close_money = [];
        $all_money = [];

        $report = new McReportService($this->month_start);

        foreach ($this->regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            $last_close_money = $report->lastCloseMoney($region->id,$pharmacy_ids);

            $new_close_money = $report->newCloseMoney($region->id,$pharmacy_ids);

            $all_money[$region->id] = $last_close_money[$region->id] + $new_close_money[$region->id];

        }

        return array_sum($all_money);

       
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

        $new_close_money = [];
        $new_accept_money = [];
        $predoplata = [];
        $predoplata_new = [];

        $report = new McReportService($this->month_start);

        foreach ($this->regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            $new_close_money = $report->newCloseMoney($region->id,$pharmacy_ids);
            $new_accept_money = $report->newAcceptMoney($region->id,$pharmacy_ids);

            $predoplata = $report->predoplata($region->id,$pharmacy_ids);

            $predoplata_new = $report->predoplataNew($region->id,$pharmacy_ids);

            $otgruzka[$region->id] = $new_close_money[$region->id] + $new_accept_money[$region->id] + $predoplata[$region->id]-$predoplata_new[$region->id];

        }

        return array_sum($otgruzka);

        // $ords = McOrder::whereDate('order_date','<=',$this->month_end)
        //     ->get();
        //     $s = 0;
        //     foreach ($ords as $key => $value) {
        //         $mc_del = McOrderDelivery::where('order_id',$value->id)
        //         ->whereDate('created_at','>=',$this->month_start)
        //         ->whereDate('created_at','<=',$this->month_end)
        //         ->sum(DB::raw('price*quantity'));

        //         $s += $mc_del - $mc_del*$value->discount/100;
        //     }
            
        //     return $s;
    }

    public function shipmentDay()
    {
        $ords = McOrder::whereDate('order_date','<=',$this->month_end)
            ->get();
            $s = 0;
            foreach ($ords as $key => $value) {
                $mc_del = McOrderDelivery::where('order_id',$value->id)
                // ->whereDate('created_at','=',$this->month_start)
                ->where('id','>',3485)
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

            // $con = $rek_service->getOstatokLastDate();
            // $con = $rek_service->getOstatokSum();
            // $con = $rek_service->getOtgruzkaSum();
            // $con = $rek_service->getTakeofSum();
            // $con = $rek_service->getTakeOf3Month();
            // $con = $rek_service->getAverage();
            $con_sum = $rek_service->getHaveProductSum();
            // $con = $rek_service->getSatisDay();
            // $con = $rek_service->getConditionPharmacy();
            // $con = $rek_service->getRekProduct();

            $con = $rek_service->getConditionPharmacy();
            $satisday = $rek_service->getSatisDay();
            $sum = $rek_service->getRekSum($satisday,$con);

            if($con == 2)
            {
                $pharmacy_elchi_order[$value] = array('con' => $con,'sum' => $con_sum);

            }else{
                $pharmacy_elchi_order[$value] = array('con' => $con,'sum' => $sum);

            }
            

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
            
            $pul = McPaymentHistory::where('order_id',$order->id)->sum('amount');

            $yashil_sumi += $pul;
                      
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

        // dd($yashil_sumi);

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

    //sfitafor

    public function qarzdorlik()
    {
        $regions = Region::all();

        foreach ($regions as $reg => $region) {



        }
        return 123;
    }

    public function orderMoneyArrive()
    {

        $regions = Region::all();
        // $regions = Region::where('id',2)->get();

        $arr = [];

        $asosiy = [];

        foreach ($regions as $reg => $region) {
            
            // $rid = 2;
            $rid = $region->id;

            $pharmacy_id = Pharmacy::where('region_id',$rid)->pluck('id')->toArray();

            $order_pharmacy = McOrder::whereIn('pharmacy_id',$pharmacy_id)
            ->distinct('pharmacy_id')->pluck('pharmacy_id')->toArray();

            foreach ($order_pharmacy as $key => $pharmacy) {
                
                // $orders = McOrder::where('id',168)->get();
                $orders = McOrder::where('pharmacy_id',$pharmacy)
                ->whereDate('order_date','<=',$this->month_end)
                ->get();

                    $yashil_sum = 0;
                    $sariq_sum = 0;
                    $qizil_sum = 0;

                    $ord_arr = [];
                    
                    $fff= 0;

                    foreach ($orders as $ord => $order) {

                        $discount = $order->discount;

                        $all_payment = McPaymentHistory::where('order_id',$order->id)
                        ->whereDate('created_at','<=',$this->month_end)
                        ->sum('amount');

                        $asosiy[$rid][$pharmacy][$order->id][0] = $all_payment;

                        $deliverys = McOrderDelivery::where('order_id',$order->id)
                        ->sum(DB::raw('quantity*price'));

                        $return = McReturnHistory::where('order_id',$order->id)->sum('amount');

                        

                        $first_payment = McPaymentHistory::where('order_id',$order->id)->first();


                        $delivery_order = McOrderDelivery::where('order_id',$order->id)->first();

                        if($delivery_order)
                        {
                            if(strtotime($delivery_order->created_at) < strtotime($this->month_start))
                            {
                                $pul_xolat = 0;
                            }else{
                                $pul_xolat = 1;
                            }

                            $with_discount_price = $deliverys - $deliverys*$discount/100;
                            $qarz = $with_discount_price - $all_payment;

                            if($qarz > 0)
                            {

                                $detail_delivery_date = McOrderDelivery::where('order_id',$order->id)->distinct('created_at')->pluck('created_at')->toArray();
                                $del_arr = [];
                                foreach ($detail_delivery_date as $d => $del) {
                                    $d = date('Y-m-d H:i:s',strtotime($del));
                                    $h = date('H:i:s',strtotime($del));

                                    $delivery_q = McOrderDelivery::where('order_id',$order->id)
                                    ->whereDate('created_at',$d)
                                    ->whereTime('created_at', '=', $h)
                                    ->sum(DB::raw('quantity*price'));

                                    $pr = $delivery_q - $delivery_q*$order->discount/100;

                                    $del_arr[$d] = $pr;

                                }

                                $test_sum = $all_payment;
                                $date_del_arr = [];
                                foreach ($del_arr as $s => $sel) {
                                    if($test_sum > 0)
                                    {
                                        $asd = $test_sum;
                                        $test_sum = $test_sum - $sel;

                                        if($test_sum <=0 )
                                        {
                                            $date_del_arr[$sel-$asd] = $s;
                                        }
                                    }else{
                                            $date_del_arr[$sel] = $s;
                                    }
                                }
                                // dd($date_del_arr);
                                        // $arr[$order->id] = $date_del_arr;

                                $asosiy[$rid][$pharmacy][$order->id][1] = $qarz;

                                $fg = 0;
                                foreach ($date_del_arr as $f => $fe) {
                                    
                                    $day = $this->day_minus(date('Y-m-d'),$fe);

                                    $xolat = $this->analiz($pharmacy,$order->discount,$day);

                                    // if($xolat != 3)
                                    // {
                                        // $d = date('Y-m-d H:i:s',strtotime($fe));
                                        // $h = date('H:i:s',strtotime($fe));

                                        // $delivery_q = McOrderDelivery::where('order_id',$order->id)
                                        // ->whereDate('created_at',$d)
                                        // ->whereTime('created_at', '=', $h)
                                        // ->sum(DB::raw('quantity*price'));

                                        // $pr = $delivery_q - $delivery_q*$order->discount/100;

                                        $asosiy[$rid][$pharmacy][$order->id][3][$fe] = [
                                            'xolat' => $xolat,
                                            'kun' => $day,
                                            'qarz' => $f,
                                            'pul_xolat' => $pul_xolat
                                        ];

                                        // $arr[$order->id] = $date_del_arr;

                                        if($pul_xolat == 1)
                                        {
                                            $fff += $f;
                                            $arr[$order->id] = $asosiy[$rid][$pharmacy][$order->id][3];

                                            $fg += $f;


                                        }
                                    // }


                                    

                                }


                            }


                        }else{

                            if($order->price > 0)
                            {

                                if($order->order_date < $this->month_start)
                                {
                                    $pul_xolat = 0;
                                }else{
                                    $pul_xolat = 1;
                                }

                                $with_discount_price = $order->price - $order->price*$discount/100;

                                // $ret = McReturnHistory::where('order_id',$order->id)->sum('amount');
                                
                                $qarz = $with_discount_price - $all_payment-$return;

                                $day = $this->day_minus(date('Y-m-d'),$order->order_date);

                                $day = floor((strtotime(date('Y-m-d'))-strtotime($order->order_date))/60/60/24);



                                if( $qarz > 0 )
                                {
                                    $xolat = $this->analiz($pharmacy,$order->discount,$day);

                                    $asosiy[$rid][$pharmacy][$order->id][1] = $qarz;

                                    // if($xolat != 3)
                                    // {

                                    

                                        $asosiy[$rid][$pharmacy][$order->id][3][$order->order_date] = [
                                            'xolat' => $xolat,
                                            'kun' => $day,
                                            'qarz' => $qarz,
                                            'pul_xolat' => $pul_xolat,

                                        ];

                                        if($pul_xolat == 1)
                                        {
                                            $fff += $qarz;
                                        }
                                        // $arr[$order->id] = $asosiy[$rid][$pharmacy][$order->id][3];
                                    // }

                                }

                            }

                        }

                    }


                // $arr[$pharmacy] = $orders;

            }


        }

        return $asosiy;
        // dd($asosiy);
    }


    public function analiz($pid,$discount,$day)
    {
        $pharmacy = McDeadlinePharmacy::where('pharmacy_id',$pid)->first();

        if($pharmacy)
        {
            $an = $pharmacy->day - $day;
        }else{
            $region = Pharmacy::find($pid);
            $region_id = McDeadlinePharmacy::where('region_id',$region->id)->first();
            if($region_id)
            {
                $an = $region_id->day - $day;
            }else{
                if($discount < 10)
                {
                    $an = 31 - $day;

                }elseif($discount < 15 && $discount >= 10)
                {
                    $an = 16 - $day;
                }elseif($discount < 30 && $discount >= 15)
                {
                    $an = 11 - $day;
                }else{
                    $an = 8 - $day;
                }
            }
        }

        if($an == 0)
        {
            $an = -1;
        }

        if($an > 0 && $an <=3 )
        {
            $xolat = 1; //sariq
        }elseif($an < 0){
            $xolat = 2; //qizil
        }else{
            $xolat = 3; //yashil
        }

        return $xolat;

    }

    public function day_minus($date1,$date2)
    {
        $date1 = date('Y-m-d',strtotime($date1));
        $date2 = date('Y-m-d',strtotime($date2));

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        return $days;
    }
}
