<?php

namespace App\Http\Livewire;

use App\Models\McOrder;
use App\Models\McOrderDetail;
use App\Models\Medicine;
use App\Models\RmOrderProduct;
use App\Models\RmWarehouse;
use Livewire\Component;

class Shipment extends Component
{
    public $orders;
    public $warehouses;
    public $order_products =[];
    public $order_debt =[];
    public $products;
    public $medicine;

    public $status_array;
    public $view_array;
    public $active_status = 1;
    public $active_view = 1;

    protected $listeners = ['shipment' => 'shipmentOrder','change_Status' => 'changeStatus','change_View' => 'changeView'];


    public function mount()
    {
        $this->status_array[1] = 'Yangi buyurtmalar';
        $this->status_array[2] = 'Yakunlanmagan otgruzka';
        $this->status_array[3] = 'To\'liq yakunlangan otgruzka';

        $this->view_array[1] = 'align-justify';
        $this->view_array[2] = 'th';

        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')
        ->where('order_detail_status',$this->active_status)->orderBy('id','ASC')->get();

        foreach ($this->orders as $key => $value) {
            $this->order_products[$value->id] = McOrderDetail::where('order_id',$value->id)->pluck('quantity','product_id')->toArray();
            $this->order_debt[$value->id] = McOrderDetail::where('order_id',$value->id)->pluck('debt','product_id')->toArray();
        }
        // dd($this->order_products);
        $this->medicine = Medicine::orderBy('id','ASC')->get();

    }

    public function changeStatus($status)
    {
        $this->active_status = $status;
        $this->orders = McOrder::with('pharmacy','user')
        ->where('order_detail_status',$this->active_status)->orderBy('id','ASC')->get();
        $this->order_products = [];
        $this->order_debt = [];
        foreach ($this->orders as $key => $value) {
            $this->order_products[$value->id] = McOrderDetail::where('order_id',$value->id)->pluck('quantity','product_id')->toArray();
            $this->order_debt[$value->id] = McOrderDetail::where('order_id',$value->id)->pluck('debt','product_id')->toArray();

        }
    }

    public function changeView($status)
    {
        $this->active_view = $status;
    }

    public function render()
    {
        return view('livewire.shipment');
    }
}
