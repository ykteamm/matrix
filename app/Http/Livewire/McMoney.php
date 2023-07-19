<?php

namespace App\Http\Livewire;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McPaymentHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class McMoney extends Component
{
    public $orders;
    public $order_pay;
    public $order_sum;

    public function mount()
    {
        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')->orderBy('id','ASC')->get();
        foreach ($this->orders as $key => $value) {
            $this->order_pay[$value->id] = McPaymentHistory::where('order_id',$value->id)->sum('amount');
            $this->order_sum[$value->id] = McOrderDelivery::where('order_id',$value->id)->sum(DB::raw('quantity * price'));
        }
    }

    public function render()
    {
        return view('livewire.mc-money');
    }
}
