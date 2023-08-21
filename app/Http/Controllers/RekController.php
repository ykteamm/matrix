<?php

namespace App\Http\Controllers;

use App\Models\McOrder;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Price;
use App\Models\ProductSold;
use App\Models\Shablon;
use App\Services\RekServices;
use Illuminate\Http\Request;

class RekController extends Controller
{
    public function index22() 
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


        $pharmacy_elchi_order = [];
        
        foreach ($pharmacy_sold as $key => $value) {
            // foreach ($elchi_otgruzka as $key => $value) {
            if($value != null)
            {
                $rek_service = new RekServices($value);

                $pharmacy_elchi_order[] = array('ph' => Pharmacy::where('id',$value)->first(),'con' => $rek_service->getConditionPharmacy());
            }

        }

        $pharmacy_order = [];
        
        foreach ($otgruzka as $key => $value) {
            
            $rek_service = new RekServices($value);

            $pharmacy_order[] = array('ph' => Pharmacy::where('id',$value)->first(),'con' => $rek_service->getConditionPharmacy());

        }

        $pharmacy_elchi = [];
        
        foreach ($elchi as $key => $value) {
            
            $rek_service = new RekServices($value);

            $pharmacy_elchi[] = array('ph' => Pharmacy::where('id',$value)->first(),'con' => $rek_service->getConditionPharmacy());

        }

        // dd($pharmacy_elchi);


        // $pharmacy_order = Pharmacy::whereIn('id',$otgruzka)->get();
        // $pharmacy_elchi = Pharmacy::whereIn('id',$elchi)->get();

        $max = max(count($elchi_otgruzka),count($otgruzka),count($elchi));

        return view('rek.index',[
            'max' => $max,
            'pharmacy_elchi_order' => $pharmacy_elchi_order,
            'pharmacy_order' => $pharmacy_order,
            'pharmacy_elchi' => $pharmacy_elchi,
        ]);
    }

    public function index() 
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

            $pharmacy_elchi_order[] = array('ph' => Pharmacy::where('id',$value)->first(),'con' => $rek_service->getConditionPharmacy());

        }




        return view('rek.index',[
            'pharmacy_elchi_order' => $pharmacy_elchi_order
        ]);
    }

    public function pharmacy($id)
    {
        $shablon = Shablon::find(3);

        $rek_service = new RekServices($id);

        $product = $rek_service->getRekProduct();

        // dd($product);

        $rek_product = [];
        $all_sum = 0;
        foreach ($product as $key => $value) {
            $price = Price::where('shablon_id',$shablon->id)->where('medicine_id',$key)->first();
            $sum = $price->price*$value;
            $rek_product[] = array('product' => Medicine::find($key),'price' => $sum, 'number' => $value);
            $all_sum += $sum;
        }

        return view('rek.rek',compact('all_sum','rek_product'));

    }
}

