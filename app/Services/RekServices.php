<?php

namespace App\Services;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\Price;
use App\Models\ProductSold;
use App\Models\Shablon;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class RekServices
{
    public $pharmacy_id;
    public $month_last_3;
    public $days = 30;

    public function __construct($id)
    {
        $this->pharmacy_id = $id;
        $this->month_last_3 = date('Y-m-d',strtotime('-3 month',strtotime(date('Y-m-d'))));

    }   

    public function getOstatokLastDate()
    {
        $last_date=Stock::where('pharmacy_id',$this->pharmacy_id)->orderBy('id','DESC')->first();

        if($last_date)
        {
            $last_date = date('Y-m-d',strtotime($last_date->date_time));
        }else{
            $last_date = NULL; 
        }

        return $last_date;
    }

    public function getOstatokSum()
    {
        $shablon = Shablon::find(3);

        $ostatok=Stock::where('pharmacy_id',$this->pharmacy_id)
        ->whereDate('date_time',$this->getOstatokLastDate())
        ->get();

        $sum = 0;

        foreach ($ostatok as $key => $value) {
            if($value->number != NULL)
            {
                $price = Price::where('shablon_id',$shablon->id)->where('medicine_id',$value->medicine_id)->first();
                $sum += $value->number*$price->price;
            }
        }

        return $sum;
    }

    public function getOtgruzkaSum()
    {
        $order_ids = McOrder::where('pharmacy_id',$this->pharmacy_id)->pluck('id')->toArray();

        $order = McOrderDelivery::whereIn('order_id',$order_ids)
                 ->whereDate('created_at','>=',$this->getOstatokLastDate())
                 ->sum(DB::raw('quantity*price'));
        return $order;
    }

    public function getTakeofSum()
    {

        $takeof = ProductSold::where('pharm_id',$this->pharmacy_id)
                 ->whereDate('created_at','>=',$this->getOstatokLastDate())
                 ->sum(DB::raw('number*price_product'));
        return $takeof;
    }

    public function getTakeOf3Month()
    {
        $takeof = ProductSold::where('pharm_id',$this->pharmacy_id)
                 ->whereDate('created_at','<=',$this->getOstatokLastDate())
                 ->whereDate('created_at','>=',$this->month_last_3)
                 ->sum(DB::raw('number*price_product'));
                
        if($takeof == 0)
        {
            $takeof = ProductSold::where('pharm_id',$this->pharmacy_id)
                 ->sum(DB::raw('number*price_product'));

           
        }

        $dates = ProductSold::where('pharm_id',$this->pharmacy_id)->pluck('created_at')->toArray();
        $arr = [];
        foreach ($dates as $key => $value) {
            // $d = strtotime('Y-m-d',$value);
            $arr[] = $value;
        }
        return $arr;
    }

    public function getAverage()
    {
        return $this->getTakeOf3Month()/$this->days;
    }

    public function getHaveProductSum()
    {
        $ostatok = $this->getOstatokSum()+$this->getOtgruzkaSum()-$this->getTakeofSum();

        return $ostatok;
    }

    public function getSatisDay()
    {
        return ($this->getAverage() == 0) ? 0 : floor($this->getHaveProductSum()/$this->getAverage());

    }

    public function getConditionPharmacy()
    {
        if($this->getOstatokLastDate() == null)
        {
            return -1;
        }
        if($this->getSatisDay() <= 5)
        {
            $color = 0; //qizil
        }elseif($this->getSatisDay() > 5 && $this->getSatisDay() < 14){
            $color = 1;  //sariq
        }else{
            $color = 2;  //yashil
        }

        return $color;
    }

    public function getKoef()
    {

        if($this->getHaveProductSum() == 0)
        {
            return 0;
        }else{
            return $this->getTakeOf3Month()/$this->getHaveProductSum();
        }
    }

    public function getRekProduct()
    {
        if($this->getSatisDay() < 30)
        {
            $day = 30;
        }else{
            $day = $this->getSatisDay();
        }

        $rek = ProductSold::selectRaw('SUM(number) as sum,medicine_id')
                 ->where('pharm_id',$this->pharmacy_id)
                 ->whereDate('created_at','<=',$this->getOstatokLastDate())
                 ->whereDate('created_at','>=',$this->month_last_3)
                 ->orderBy('sum','DESC')
                 ->groupBy('medicine_id')
                 ->pluck('sum','medicine_id')->toArray();

        $arr = [];

        foreach ($rek as $key => $value) {
            
            $number = ($this->getKoef($day) == 0) ? 3 : round($value/$this->getKoef());

            $number = ($number == 0) ? 1 : $number;
            
            $arr[$key] = $number;
        }
        return $arr;
    }
}
