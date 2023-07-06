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

    public function shipment()
    {
        return view('order.shipment');
    }
}
