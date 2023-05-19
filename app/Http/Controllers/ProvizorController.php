<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProvizorController extends Controller
{
    public function index()
    {

        $orders = Http::get(getProvizorUrl().'/api/orders')->collect();

        return view('provizor.index',[
            'orders' => $orders
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

        return $response[0]['product']->id;
        // if($response)
        // {
        //     return redirect()->back();
        // }
    }

    public function money()
    {

        $provizors = Http::get(getProvizorUrl().'/api/provizors')->collect();


        return view('provizor.money',[
            'provizors' => $provizors
        ]);

    }

    public function moneyStore(Request $request)
    {
        $response = Http::post(getProvizorUrl().'/api/money-arrival', [
            'provizor_id' => $request->provizor_id,
            'money' => $request->money,
            'date' => $request->date,
        ]);

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


}
