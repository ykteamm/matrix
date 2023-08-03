<?php

namespace App\Http\Controllers;

use App\Models\PromoOrder;
use App\Models\PromoUser;
use App\Models\Region;
use Illuminate\Http\Request;

class PromoController extends Controller
{

    public function index()
    {
        $orders = PromoOrder::with('user')
        ->orderBy('created_at','DESC')->orderBy('status','ASC')->get();


        dd($orders);

        $orders222 = PromoUser::with([
            'order' => function($q) {
                $q->where('status','!=',5);
            }])
            ->get();

            $reg = [];

        foreach ($orders222 as $key => $value) {
            $reg[] = $value['region_id'];
        }
        $regions = Region::whereIn('id',$reg)->get();

        return view('promo.index',[
                    'orders222' => $orders222,
                    'orders' => $orders,
                    'regions' => $regions
                ]); 

    }



    // $orders222 = Http::get(getProvizorUrl().'/api/hisobot')->collect();

    //     $reg = [];

    //     foreach ($orders222 as $key => $value) {
    //         $reg[] = $value['region_id'];
    //     }
    //     $regions = Region::whereIn('id',$reg)->get();

    //     $orders = Http::get(getProvizorUrl().'/api/orders')->collect();

    //     return view('provizor.index',[
    //         'orders222' => $orders222,
    //         'orders' => $orders,
    //         'regions' => $regions
    //     ]); 
}
