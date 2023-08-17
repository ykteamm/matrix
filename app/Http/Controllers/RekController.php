<?php

namespace App\Http\Controllers;

use App\Models\McOrder;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Services\RekServices;
use Illuminate\Http\Request;

class RekController extends Controller
{
    public function index() 
    {
        $pharmacy_order = McOrder::distinct('pharmacy_id')->pluck('pharmacy_id')->toArray();


        $pharmacy_sold = ProductSold::distinct('pharm_id')->pluck('pharm_id')->toArray();

        $elchi_otgruzka = [];
        $elchi = [];
        $otgruzka = [];

        foreach ($pharmacy_order as $key => $value) {
            if($value != null)
            {
                if(in_array($value,$pharmacy_sold))
                {
                    $elchi_otgruzka[] = $value;
                }else{
                    $otgruzka[] = $value;
                }
            }
        }

        foreach ($pharmacy_sold as $key => $value) {
            if($value != null)
            {
                if(!in_array($value,$elchi_otgruzka))
                {
                    $elchi[] = $value;
                }
            }
            
        }


        $pharmacy_elchi_order = Pharmacy::whereIn('id',$elchi_otgruzka)->get();
        $pharmacy_order = Pharmacy::whereIn('id',$otgruzka)->get();
        $pharmacy_elchi = Pharmacy::whereIn('id',$elchi)->get();

        $max = max(count($elchi_otgruzka),count($otgruzka),count($elchi));
        // dd($max);

        return view('rek.index',[
            'max' => $max,
            'pharmacy_elchi_order' => $pharmacy_elchi_order,
            'pharmacy_order' => $pharmacy_order,
            'pharmacy_elchi' => $pharmacy_elchi,
        ]);
    }

    public function pharmacy($id)
    {
        $rek_service = new RekServices($id);

        $ostatka = $rek_service->getOstatokLastDate();

        if(!$ostatka)
        {
            return 123123;
        }

        $ostatok = $rek_service->getOstatokSum()+$rek_service->getOtgruzkaSum()-$rek_service->getTakeofSum();

        $average = $rek_service->getAverage();

        $next_day = floor($ostatok/$average);

        if($next_day < 10)
        {
            $color = 0;
        }elseif($next_day > 10 && $next_day < 30){
            $color = 1;
        }else{
            $color = 2;
        }
        dd($color);
        // dd($rek_service->getAverage());
        // dd($rek_service->getOstatokSum(),$rek_service->getOtgruzkaSum(),$rek_service->getTakeofSum());
    }
}
