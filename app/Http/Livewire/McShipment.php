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

class McShipment extends Component
{
    public $orders;
    public $warehouses;
    public $ware_products;
    public $order_products;
    public $default_orders;
    public $products;
    public $page;
    public $discount;
    public $delivery;
    public $delivery_id;
    public $order_id;
    public $status_array = [];
    public $active_status = 1;
    public $ware_id = 1;
    public $saved = 3;
    public $order_datail_status;
    public $payments;
    public $payment_id;

    public $amount;

    public $restart;

    public $detail_delivery;
    public $detail_delivery_date;

    public $error;

    protected $listeners = ['shipment' => 'shipmentOrder','order_List' => 'orderList', 'save' => 'saveData','change_Status' => 'changeStatus'
    ,'saveMoney_Coming' => 'saveMoneyComing','delete_Error' => 'deleteError'
    ];


    public function mount($order_id)
    {
        $this->order_id = $order_id;

        $this->order_products = McOrderDetail::with('medicine')->where('order_id',$order_id)->orderBy('id','ASC')->get();


        $this->default_orders = McOrderDetail::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();
        

        foreach ($this->default_orders as $key => $value) {
            $this->products[$key] = 0;
        }


        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')->find($order_id);
        
        $this->order_datail_status = $this->orders->order_detail_status;

        if($this->orders->delivery_id)
        {
            $this->delivery_id = $this->orders->delivery_id;
        }

        $this->selectWarehouse($this->ware_id);

        $this->discount = $this->orders->discount;

        $this->warehouses = McWarehouse::all();
        $this->delivery = McDelivery::all();

        if($this->order_datail_status != 1)
        {
            // $this->detail_delivery = McOrderDelivery::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();
            $this->detail_delivery_date = McOrderDelivery::where('order_id',$order_id)->distinct('created_at')->pluck('created_at')->toArray();
                foreach ($this->detail_delivery_date as $key => $value) {
                    $delivery_q = McOrderDelivery::where('order_id',$order_id)->where('created_at',$value)->pluck('quantity','product_id')->toArray();
                    $this->detail_delivery[] = $delivery_q;
                }

            // dd($detail_delivery);
        }
        $this->payments = McPayment::all();

        $this->ware_products = McWarehousQuantity::where('warehouse_id',$this->ware_id)->pluck('quantity','product_id')->toArray();

    }


    public function selectWarehouse($warehouse_id)
    {
        $this->ware_products = McWarehousQuantity::where('warehouse_id',$warehouse_id)->pluck('quantity','product_id')->toArray();

        foreach ($this->default_orders as $pro_id => $quantity) {
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
        if($quantity == "")
        {
            $quantity = 0;
        }

        if(gettype($quantity) == 'string')
        {
            $quantity = intval($quantity);
        }

        $this->products[$id] = $quantity;

        // $this->saved = 3;

        // dd($this->products);

        // foreach ($this->products as $pro_id => $quantity) {
        //     if($quantity > $this->ware_products[$pro_id])
        //     {
        //         $this->saved = 1;
        //     }
        //     if($quantity = $this->ware_products[$pro_id])
        //     {
        //         $this->saved = 2;
        //     }
        // }


        // if($this->saved != 1)
        // {
        //     $this->saved = 2;
        // }

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

    public function check()
    {
        $this->saved = 3;

        foreach ($this->products as $pro_id => $quantity) {
            if($quantity > $this->ware_products[$pro_id])
            {
                $this->saved = 1;
            }
        }

        if(array_sum($this->products) == 0)
        {
            $this->saved = 1;
        }

        if($this->saved != 1)
        {
            $this->saved = 2;
        }

        foreach($this->order_products as $ord)
            {

                if($ord->debt == 0)
                {
                    if($ord->quantity < $this->products[$ord->product_id])
                        {
                            $this->saved = 1;
                        }
                }else{
                    if($ord->debt < $this->products[$ord->product_id])
                        {
                            $this->saved = 1;
                        }
                }

                $sum = McOrderDelivery::where('order_detail_id',$ord->id)->sum('quantity');

                if($sum + $this->products[$ord->product_id] > $ord->quantity)
                {
                    $this->saved = 1;
                }

            }
    }

    public function saveData()
    {
        $this->check();

        if($this->saved == 2)
        {

            foreach($this->order_products as $ord)
            {
                

                if($ord->debt == 0)
                {
                    $sum = McOrderDelivery::where('order_detail_id',$ord->id)->sum('quantity');

                    if($sum + $this->products[$ord->product_id] != $ord->quantity)
                    {
                        if($ord->quantity >= $this->products[$ord->product_id])
                        {
                            $update = McOrderDetail::find($ord->id);
                            $update->debt = $update->debt + $ord->quantity - $this->products[$ord->product_id];
                            $update->save();
                        }
                    }

                    
                }else{
                    if($ord->debt >= $this->products[$ord->product_id])
                        {
                            $update = McOrderDetail::find($ord->id);
                            $update->debt = $update->debt - $this->products[$ord->product_id];
                            $update->save();
                        }
                }

                
                
                    McOrderDelivery::create([
                        'order_id' => $this->order_id,
                        'order_detail_id' => $ord->id,
                        'product_id' => $ord->product_id,
                        'quantity' => $this->products[$ord->product_id],
                        'price' => $ord->price,
                    ]);
                
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

        }else{
            $this->error = 1;
        }

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

        $this->emit('shipment');
        $this->restart = $this->order_id;
    }  

    public function runError()
    {
        $this->error = 1;
    }

    public function deleteError()
    {
        $this->error = 2;
        $this->dispatchBrowserEvent('refresh-page'); 
    }

    public function render()
    {
        return view('livewire.mc-shipment');
    }
}
