<?php

namespace App\Http\Livewire;

use App\Models\RmOrder;
use App\Models\RmOrderProduct;
use App\Models\RmWarehouse;
use Livewire\Component;

class Shipment extends Component
{
    public $orders;
    public $warehouses;
    public $order_products;
    public $products;
    public $page;


    protected $listeners = ['shipment' => 'shipmentOrder',];


    public function mount()
    {
        $this->orders = RmOrder::with('pharmacy')->get();
    }

    public function shipmentOrder($order_id)
    {
        $this->order_products = RmOrderProduct::with('medicine')->where('order_id',$order_id)->get();

        $this->products = RmOrderProduct::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();

        $this->orders = RmOrder::find($order_id);

        $this->warehouses = RmWarehouse::pluck('quantity','product_id')->toArray();
        $this->page = 1;
    }

    public function changeQuantity($quantity,$id)
    {
        $this->products[$id] = $quantity;
    }   

    public function changeDiscount($discount)
    {
        
    }

    public function render()
    {
        return view('livewire.shipment');
    }
}
