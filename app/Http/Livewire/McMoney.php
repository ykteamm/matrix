<?php

namespace App\Http\Livewire;

use App\Models\McOrder;
use App\Models\McPaymentHistory;
use Livewire\Component;

class McMoney extends Component
{
    public $orders;
    public $order_pay;

    public function mount()
    {
        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')->orderBy('id','ASC')->get();
        foreach ($this->orders as $key => $value) {
            $this->order_pay[$value->id] = McPaymentHistory::where('order_id',$value->id)->sum('amount');
        }
    }

    public function render()
    {
        return view('livewire.mc-money');
    }
}
