<?php

namespace App\Http\Livewire;

use App\Models\McDelivery;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPayment;
use App\Models\McPaymentHistory;
use App\Models\McWarehouse;
use App\Models\McWarehousQuantity;
use App\Models\RmOrder;
use App\Models\RmOrderProduct;
use App\Models\RmWarehouse;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class McShipmentDetail extends Component
{
    public $orders;
    public $warehouses;
    public $ware_products;
    public $order_products;
    public $products;
    public $page;
    public $discount;
    public $delivery;
    public $delivery_id;
    public $order_id;
    public $status_array = [];
    public $active_status = 1;
    public $saved = 3;

    public $payments;
    public $payment_id;

    public $amount;

    public $restart;

    public $detail_delivery;

    protected $listeners = ['shipment' => 'shipmentOrder','order_List' => 'orderList', 'save' => 'saveData','change_Status' => 'changeStatus'
    ,'saveMoney_Coming' => 'saveMoneyComing'
    ];


    public function mount($order_id)
    {
        $this->shipmentOrder($order_id);
        // $this->status_array[1] = 'Yangi buyurtmalar';
        // $this->status_array[2] = 'Yakunlanmagan otgruzka';
        // $this->status_array[3] = 'To\'liq yakunlangan otgruzka';
        // $this->orders = McOrder::with('pharmacy','user')->where('order_detail_status',$this->active_status)->get();
    }

    public function changeStatus($status)
    {
        $this->active_status = $status;
        $this->orders = McOrder::with('pharmacy','user')->where('order_detail_status',$this->active_status)->get();
    }

    public function shipmentOrder($order_id)
    {
        $this->order_id = $order_id;

        $this->order_products = McOrderDetail::with('medicine')->where('order_id',$order_id)->get();

        $this->products = McOrderDetail::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();

        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')->find($order_id);
        
        $this->discount = $this->orders->discount;

        $this->warehouses = McWarehouse::all();
        $this->delivery = McDelivery::all();

        $this->detail_delivery = McOrderDelivery::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();

        $this->payments = McPayment::all();

        $this->page = 1;
    }

    public function selectWarehouse($warehouse_id)
    {
        $this->ware_products = McWarehousQuantity::where('warehouse_id',$warehouse_id)->pluck('quantity','product_id')->toArray();

        foreach ($this->products as $pro_id => $quantity) {
            if($quantity > $this->ware_products[$pro_id])
            {
                $this->saved = 1;
            }
        }

        if($this->saved != 1)
        {
            $this->saved = 2;
        }

    }

    public function changeQuantity($quantity,$id)
    {
        $this->products[$id] = intval($quantity);

        $this->saved = 3;

        foreach ($this->products as $pro_id => $quantity) {
            if(intval($quantity) > $this->ware_products[$pro_id])
            {
                $this->saved = 1;
            }
        }


        if($this->saved != 1)
        {
            $this->saved = 2;
        }

    }   

    public function selectDelivery($delivery_id)
    {
        $this->delivery_id = $delivery_id;
    }

    public function changeDiscount($discount)
    {
        if($discount == null || !isset($discount) || $discount == 'Undefined')
        {
            $this->discount = 0;
        }else{
            $this->discount = $discount;
        }
    }

    public function orderList()
    {
        $this->dispatchBrowserEvent('refresh-page'); 
    }

    public function saveData()
    {
        foreach($this->order_products as $ord)
        {
            McOrderDelivery::create([
                'order_id' => $this->order_id,
                'order_detail_id' => $ord->id,
                'product_id' => $ord->product_id,
                'quantity' => $this->products[$ord->product_id],
                'price' => $ord->price,
            ]);

            if($ord->quantity > $this->products[$ord->product_id])
            {
                $update = McOrderDetail::find($ord->id);
                $update->debt = $update->debt + $ord->quantity - $this->products[$ord->product_id];
                $update->save();
            }
        }

        $debt_count = McOrderDetail::where('order_id',$this->order_id)->sum('debt');

        if($debt_count == 0)
        {
            $order_detail_status = 3;
        }else{
            $order_detail_status = 2;
        }

        McOrder::where('id',$this->order_id)->update([
            'discount' => $this->discount,
            'status' => 2,
            'order_detail_status' => $order_detail_status,
            'delivery_id' => $this->delivery_id,
        ]);

        $this->dispatchBrowserEvent('refresh-page'); 

    }

    public function selectPayment($id)
    {
        $this->payment_id = $id;
    }

    public function addPayAmount($amount)
    {
        $this->amount = $amount;
    }
    
    public function saveMoneyComing()
    {
        McPaymentHistory::create([
            'payment_id' => $this->payment_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount
        ]);

        $this->restart = $this->order_id;
    }

    public function render()
    {
        return view('livewire.mc-shipment');
    }
}
