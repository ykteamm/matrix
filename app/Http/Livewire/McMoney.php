<?php

namespace App\Http\Livewire;

use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class McMoney extends Component
{
    public $orders;
    public $order_pay;
    public $order_sum;

    public $begin;
    public $end;

    public function mount($begin = null,$end = null)
    {
        if($begin != NULL && $end != NULL)
        {
            $ids = $this->selectMonth($begin,$end);
        }else{
            $ids = McOrder::pluck('id')->toArray();
        }

            $this->orders = McOrder::with('pharmacy','pharmacy.region','user','employe','delivery','payment')->whereIn('id',$ids)->orderBy('id','ASC')->get();

        foreach ($this->orders as $key => $value) {
            $this->order_pay[$value->id] = McPaymentHistory::where('order_id',$value->id)->sum('amount');
            $this->order_sum[$value->id] = McOrderDelivery::where('order_id',$value->id)->sum(DB::raw('quantity * price'));
        }
    }

    public function selectMonth($month,$end_month) 
    {
        $ids = [];
        $orders = McOrder::all();

        foreach ($orders as $key => $value) {
            $money = McPaymentHistory::where('order_id',$value->id)
                ->where('created_at','>=',$month)
                ->where('created_at','<=',$end_month)
                ->count();
            $deliver = McOrderDelivery::where('order_id',$value->id)
                ->where('created_at','>=',$month)
                ->where('created_at','<=',$end_month)
                ->count();
            $return = McReturnHistory::where('order_id',$value->id)
                ->where('created_at','>=',$month)
                ->where('created_at','<=',$end_month)
                ->count();
            $ord = McOrder::where('id',$value->id)
                ->where('order_date','>=',$month)
                ->where('order_date','<=',$end_month)
                ->count();

            if($money > 0 || $deliver > 0 || $return > 0 || $ord > 0)
            {
                $ids[] = $value->id;
            }
        }

        return $ids; 
    }   
    public function render()
    {
        return view('livewire.mc-money');
    }
}
