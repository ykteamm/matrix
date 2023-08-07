<?php

namespace App\Http\Controllers;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\ProductSold;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function mcAdmin()
    {
        $orders = McOrder::with('pharmacy')->orderBy('id','ASC')->get();
        return view('order.report-admin',[
            'orders' => $orders
        ]);
    }

    public function mcOrderRestore($id)
    {
        $order = McOrder::find($id);

        $order_details = McOrderDetail::where('order_id',$order->id)->get();

        $minus_sum = 0;


        foreach ($order_details as $key => $value) {
            if($value->debt > 0)
            {
                $minus_sum += ($value->debt)*$value->price;

                McOrderDetail::where('id',$value->id)->update([
                    'quantity' => $value->quantity-$value->debt,
                    'debt' => 0,
                ]);
            }
        }

        $order = McOrder::where('id',$id)->update([
            'price' => $order->price-$minus_sum,
            'order_detail_status' => 3,
        ]);
        

        

        return redirect()->back();
    }

    public function pharmacy()
    {
        $pharmacy_ids = Http::get(getProvizorUrl().'/api/pharmacy');

        $all_ids = Pharmacy::orderBy('id','ASC')->pluck('id','name')->toArray();
        
        $use_order = [];
        $use_no_order = [];

        foreach ($pharmacy_ids['use_order'] as $key => $value) {
            $use_order[$value] = Pharmacy::with('region')->where('id',$value)->first();
        }
        foreach ($pharmacy_ids['use_no_order'] as $key => $value) {
            $use_no_order[$value] = Pharmacy::with('region')->where('id',$value)->first();
        }

        $mc_order = [];

        $pharmacy_mc_ids = McOrder::pluck('pharmacy_id')->toArray();

        foreach ($pharmacy_mc_ids as $key => $value) {
            $mc_order[$value] = Pharmacy::with('region')->where('id',$value)->first();
        }

        $sold = [];

        $pharmacy_sold_ids = ProductSold::distinct('pharm_id')->pluck('pharm_id')->toArray();

        foreach ($pharmacy_sold_ids as $key => $value) {
            $sold[$value] = Pharmacy::with('region')->where('id',$value)->first();
        }

        $elchi = [];

        $user_pharm = PharmacyUser::pluck('pharma_id')->toArray();

        foreach ($user_pharm as $key => $value) {
            $elchi[$value] = Pharmacy::with('region')->where('id',$value)->first();
        }

        return view('order.pharmacy',[
            'all_ids' => $all_ids,
            'use_order' => $use_order,
            'use_no_order' => $use_no_order,
            'mc_order' => $mc_order,
            'sold' => $sold,
            'elchi' => $elchi,
            // 'provizor' => $provizor,
            // 'order' => $order,
            // 'sold' => $sold,
            // 'other' => $other,
        ]);

        // return $pharmacy_ids['use_order'];

        // $pharmacy_mc_ids = McOrder::pluck('pharmacy_id')->toArray();



        // $pharmacy_sold_ids = ProductSold::distinct('pharm_id')->pluck('pharm_id')->toArray();

        // $all_ids = Pharmacy::pluck('id')->toArray();


        // $provizor = Pharmacy::with('region')->whereIn('id',$pharmacy_ids)->get();

        // $order = Pharmacy::with('region')-> whereIn('id',$pharmacy_mc_ids)->get();

        // $sold = Pharmacy::with('region')->whereIn('id',$pharmacy_sold_ids)->get();

        // foreach ($pharmacy_ids as $key => $value) {
        //     if(in_array($value,$all_ids))
        //     {
        //         if (($key = array_search($value, $all_ids)) !== false) {
        //             unset($all_ids[$key]);
        //         }
        //     }
        // }
        // foreach ($pharmacy_mc_ids as $key => $value) {
        //     if(in_array($value,$all_ids))
        //     {
        //         if (($key = array_search($value, $all_ids)) !== false) {
        //             unset($all_ids[$key]);
        //         }
        //     }
        // }foreach ($pharmacy_sold_ids as $key => $value) {
        //     if(in_array($value,$all_ids))
        //     {
        //         if (($key = array_search($value, $all_ids)) !== false) {
        //             unset($all_ids[$key]);
        //         }
        //     }
        // }


        // $other = Pharmacy::with('region')->whereIn('id',$all_ids)->get();

        // return $other;

        return view('order.pharmacy',[
            // 'provizor' => $provizor,
            // 'order' => $order,
            // 'sold' => $sold,
            // 'other' => $other,
        ]);
    }
}
