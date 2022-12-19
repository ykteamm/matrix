<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Region;
use DB;
class Counter extends Component
{
    public $factor = ['Sales','Elchi soni','Check'];
    public $index = 0;
    public $final;
    public $region ;
    public function increment($index)
    {

        $this->index++;
        if($this->index == 3)
        {
            $this->index = 0;
        }
        $this->factor[$this->index];
    }
    public function render()
    {
        if($this->index == 0)
        {
            $this->region = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_region.id,tg_region.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-4 day',strtotime(date_now()))))
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_region.id')->get();
        }
        if($this->index == 1)
        {
            $this->region = DB::table('tg_user')
                    ->selectRaw('count(tg_user.region_id) as allprice,tg_region.id,tg_region.name')
                    ->whereIn('tg_user.level',[1,2])
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_region.id')->get();
        }
        if($this->index == 2)
        {
            $this->region = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_region.name,tg_order.id')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-1 day',strtotime(date_now()))))
                    ->join('tg_order','tg_order.id','tg_productssold.order_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_order.id')->get();
        }
        return view('livewire.counter');
    }
}
