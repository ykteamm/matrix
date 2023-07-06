<?php

namespace App\Http\Livewire;

use App\Models\RmOrder;
use Livewire\Component;

class Shipment extends Component
{
    public $orders;
    public $orders;

    public function mount()
    {
        $this->orders = RmOrder::orderBy('id','ASC')->get();
    }

    public function selectOrder($order_id)
    {

    }

    public function render()
    {
        return view('livewire.shipment');
    }
}
