<?php

namespace App\Http\Controllers;

use App\Http\Livewire\McMoney;
use App\Models\McDeadlinePharmacy;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPayment;
use App\Models\McPaymentHistory;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\ProductSold;
use App\Models\Region;
use App\Models\Shift;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


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

    public function mcMoneymonth($begin,$end)
    {
        return view('order.money-month',[
            'begin' => $begin,
            'end' => $end,
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

    public function lastOrders()
    {
        $pharmacy = Pharmacy::with('region')->get();
        $money = McPayment::all();

        $code = McOrder::orderBy('id','DESC')->first()->id;


        return view('order.last',[
            'pharmacy' => $pharmacy,
            'money' => $money,
            'code' => $code,
        ]);
    }

    public function lastOrdersSave(Request $request)
    {

        if($request->money_action == 1)
        {
            $new_order = McOrder::create([

                'pharmacy_id' => $request->pharmacy_id,
                'employee_id' => Session::get('user')->id,
                'number' => $request->code,
                'price' => $request->money,
                'discount' => 0,
                'delivery_id' => 2,
                'order_date' => $request->month,
                'outer' => 1,
    
            ]);
        }else{
            $new_order = McOrder::create([
                'pharmacy_id' => $request->pharmacy_id,
                'employee_id' => Session::get('user')->id,
                'number' => $request->code,
                'discount' => 0,
                'delivery_id' => 2,
                'order_date' => $request->month,
                'outer' => 1,
            ]);
    
            McPaymentHistory::create([
                'payment_id' => $request->money_status,
                'order_id' => $new_order->id,
                'amount' => $request->money*100/100
            ]);
        }

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


        $ostatka = [];
        $ostatka_date = [];

        $date_begin = date('Y-m-d',(strtotime ( '-40 day' , strtotime ( date('Y-m-d')) ) ));

        $ostatka_pharm = Stock::distinct('pharmacy_id')->pluck('pharmacy_id')->toArray();

        foreach ($ostatka_pharm as $key => $value) {
            $ostatka[$value] = Pharmacy::with('region')->where('id',$value)->first();
            $date = Stock::where('pharmacy_id',$value)->orderBy('id','DESC')->first();
            if($date)
            {
                $ostatka_date[$value] = $date->created_at;
            }
        }


        $shift = [];

        $shift_pharm = Shift::whereDate('created_at','>=',$date_begin)
        ->whereDate('created_at','<=',date('Y-m-d'))
        ->distinct('pharma_id')->pluck('pharma_id')->toArray();
        foreach ($shift_pharm as $key => $value) {

            $date = Shift::where('pharma_id',$value)->orderBy('id','DESC')->first();

            if($date)
            {
                $shift[$value] = $date->created_at;
            }
        }

        return view('order.pharmacy',[
            'all_ids' => $all_ids,
            'use_order' => $use_order,
            'use_no_order' => $use_no_order,
            'mc_order' => $mc_order,
            'sold' => $sold,
            'elchi' => $elchi,
            'ostatka' => $ostatka,
            'ostatka_date' => $ostatka_date,
            'shift' => $shift,
        ]);

        
    }

    public function mcPharmacyReturn()
    {
        $regions = Region::with('pharmacy')->get();

        $ids = McOrder::distinct('pharmacy_id')->pluck('pharmacy_id')->toArray();


        $pharmacy = Pharmacy::with('region')->whereIn('id',$ids)->get();

        return view('order.return-day',[
            'regions' => $regions,
            'pharmacy' => $pharmacy,
        ]);
    }

    public function mcRegionReturnDay(Request $request,$id)
    {
        $region = Region::with('pharmacy')->find($id);

        $new = new McDeadlinePharmacy;
        $new->region_id = $id;
        $new->day = $request->day;
        $new->save();
       
        return redirect()->back();
    }

    public function mcPharmacyReturnDay(Request $request)
    {

        $new = new McDeadlinePharmacy;
        $new->pharmacy_id = $request->pharmacy_id;
        $new->day = $request->day;
        $new->save();

        return redirect()->back();

    }

    
    public function mcChangeOrderDate(Request $request,$id)
    {
        $date = $request->change_order_date;

        $date = date('Y-m-d H:i:s',strtotime($date));


        $order = McOrder::find($id);
        $order->order_date = $date;
        $order->save();

        return redirect()->back();

    }

    public function mcChangePaymentDate(Request $request,$id)
    {
        $date = $request->change_order_date;

        $date = date('Y-m-d H:i:s',strtotime($date));


        $order = McPaymentHistory::find($id);
        $order->created_at = $date;
        $order->save();

        return redirect()->back();

    }

    public function mcChangePaymentAmount(Request $request,$id)
    {

        $date = $request->change_payment_amount;

        $order = McPaymentHistory::find($id);
        $order->amount = $date;
        $order->save();

        return redirect()->back();

    }

    public function mcChangeOrderDeliveryDate(Request $request,$id,$array)
    {

        // $value = date('Y-m-d H:i:s',strtotime($date));

        // $d = date('Y-m-d H:i:s',strtotime($value));

        // $delivery_q = McOrderDelivery::where('order_id',$id)->distinct('created_at')->pluck('created_at')->toArray();


        $random = rand(10,40);

        $date = $request->change_order_date.':'.$random;

        $date = date('Y-m-d H:i:s',strtotime($date));

        $arr = json_decode($array);


        $delivery_q = McOrderDelivery::where('order_id',$id)->whereIn('id',$arr)->update([
            'created_at' => $date
        ]);
        
        return redirect()->back();

    }

    public function mcChangePaymentLast($id)
    {
        $order = McPaymentHistory::find($id);

        if($order->last == 0)
        {
            $order->last = 1;
        }else{
            $order->last = 0;
        }

        $order->save();
        
        return redirect()->back();

    }

    
}
