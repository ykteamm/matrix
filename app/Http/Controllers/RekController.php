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

        if($average == 0)
        {
            $next_day = 0;

        }else{
            $next_day = floor($ostatok/$average);

        }


        if($next_day <= 5)
        {
            $color = 0; //qizil
        }elseif($next_day > 5 && $next_day < 25){
            $color = 1;  //sariq
        }else{
            $color = 2;  //yashil
        }

        dd($rek_service->getRekProduct());

        return $next_day;
        // dd($color);
        // dd($rek_service->getAverage());
        // dd($rek_service->getOstatokSum(),$rek_service->getOtgruzkaSum(),$rek_service->getTakeofSum());
    }
}

