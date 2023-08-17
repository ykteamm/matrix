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

    public function __construct($id)
    {
        $this->pharmacy_id = $id;
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

    public function getAverage()
    {

        $month_last_3 = date('Y-m-d',strtotime('-3 month',strtotime(date('Y-m-d'))));

        $takeof = ProductSold::where('pharm_id',$this->pharmacy_id)
                 ->whereDate('created_at','<=',$this->getOstatokLastDate())
                 ->whereDate('created_at','>=',$month_last_3)
                 ->sum(DB::raw('number*price_product'));
                 
        return $takeof/90;
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
}
