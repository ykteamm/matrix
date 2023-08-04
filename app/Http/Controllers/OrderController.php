<?php

namespace App\Http\Controllers;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Models\Region;
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
    public function orderDelete($order_id)
    {

        McOrder::destroy($order_id);
        McOrderDetail::where('order_id',$order_id)->delete();
        McOrderDelivery::where('order_id',$order_id)->delete();
        McPaymentHistory::where('order_id',$order_id)->delete();

        return redirect()->back();
    }
    
    public function report()
    {
        return view('order.report');
    }
}
