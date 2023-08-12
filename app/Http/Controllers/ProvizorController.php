<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProvizorController extends Controller
{
    public function index()
    {

        $orders222 = Http::get(getProvizorUrl().'/api/hisobot')->collect();

        $ball = Http::get(getProvizorUrl().'/api/promo-ball')->collect();

        $reg = [];

        foreach ($orders222 as $key => $value) {
            $reg[] = $value['region_id'];
        }
        $regions = Region::whereIn('id',$reg)->get();

        $orders = Http::get(getProvizorUrl().'/api/orders')->collect();

        // dd($ball);

        return view('provizor.index',[
            'orders222' => $orders222,
            'orders' => $orders,
            'regions' => $regions,
            'ball' => $ball,
        ]);

    }
    public function provizorHisobot()
    {

        $orders = Http::get(getProvizorUrl().'/api/hisobot')->collect();

        $reg = [];

        foreach ($orders as $key => $value) {
            $reg[] = $value['region_id'];
        }
        $regions = Region::whereIn('id',$reg)->get();

        return view('provizor.hisobot',[
            'orders' => $orders,
            'regions' => $regions
        ]);

    }

    public function changeOrderStatus($order_id,$status)
    {
        $response = Http::post(getProvizorUrl().'/api/change-status', [
            'order_id' => $order_id,
            'status' => $status,
        ]);

        if($response)
        {
            return redirect()->back();
        }
    }

    public function orderProduct($order_id)
    {
        $response = Http::post(getProvizorUrl().'/api/get-order', [
            'order_id' => $order_id,
        ]);

        return view('provizor.order',[
            'orders' => $response['order'],
            'count' => $response['count'],
            'name' => $response['name'],
            'order_id' => $order_id,
        ]);
    }
    public function orderProductUpdate(Request $request,$order_id)
    {
        $inputs = $request->all();

        unset($inputs['_token']);
        $product = [];
        foreach($inputs['product'] as $key => $value)
        {
            $product[$key] = $value[0];
        }

        $response = Http::post(getProvizorUrl().'/api/order-update', [
            'order_id' => $order_id,
            'product' => $product,
        ]);


        return redirect()->back();
    }

    public function orderProductDelete($order_id)
    {
        $response = Http::post(getProvizorUrl().'/api/order-delete', [
            'order_id' => $order_id,
        ]);

        return redirect()->back();
    }
    
    public function money()
    {

        $provizors = Http::get(getProvizorUrl().'/api/provizors')->collect();

        $moneys = Http::get(getProvizorUrl().'/api/moneys')->collect();

        return view('provizor.money',[
            'provizors' => $provizors,
            'moneys' => $moneys,
        ]);

    }

    public function moneyStore(Request $request)
    {
        $response = Http::post(getProvizorUrl().'/api/money-arrival', [
            'provizor_id' => $request->provizor_id,
            'money' => $request->money,
            'date' => $request->date,
        ]);

        // return $response;

        if($response['status'] == 200)
        {
            $msg = 'Saqlandi';
        }else{
            $msg = 'Pul buyurtmadan oshib ketti';
        }

        return redirect()->back()->with('msg_pro',$msg);
    }

    public function battle()
    {

        $provizors = Http::get(getProvizorUrl().'/api/provizors')->collect();


        return view('provizor.battle',[
            'provizors' => $provizors
        ]);

    }

    public function battleStore(Request $request)
    {
        $response = Http::post(getProvizorUrl().'/api/battle-store', [
            'u1id' => $request->u1id,
            'u2id' => $request->u2id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if($response['status'] == 200)
        {
            $msg = 'Saqlandi';
        }else{
            $msg = 'Pul buyurtmadan oshib ketti';
        }

        return redirect()->back()->with('msg_pro',$msg);

    }

    public function crystalHistory()
    {
        
        $hsitory = Http::get(getProvizorUrl().'/api/get-crystal-history')->collect();
        $provizors = Http::get(getProvizorUrl().'/api/provizors')->collect();
        $crystal = Http::get(getProvizorUrl().'/api/crystal')->collect();
        
        return view('provizor.crystal',[
            'provizors' => $provizors,
            'crystal' => $crystal,
            'histories' => $hsitory,
        ]);
    }

    public function crystalHistoryStore(Request $request)
    {

        $response = Http::post(getProvizorUrl().'/api/crystal-history', [
            'user_id' => $request->provizor_id,
            'crystal' => $request->crystal,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

}
