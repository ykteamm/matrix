<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function warehouse()
    {
        return view('order.warehouse');
    }
    
    public function allOrders()
    {
        return view('order.shipment');
    }

    public function shipment()
    {
        return view('order.shipment');
    }

    public function money()
    {
        return view('order.money');
    }

    public function orderPage($order_id)
    {
        return view('order.page',[
            'order_id' => $order_id
        ]);
    }
}
