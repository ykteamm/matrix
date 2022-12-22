<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Region;
use App\Services\SortService;
use DB;
class Counter extends Component
{
    public $factor = ['Sales','Elchi soni','Check'];
    public $index = 0;
    public $final;
    public $region ;
    public $day ;
    public function increment($index)
    {

        $this->index++;
        if($this->index == 3)
        {
            $this->index = 0;
        }
        $this->factor[$this->index];
    }
    public function test()
    {
        $this->day = 7;
        
    }
    public function render()
    {
        if($this->index == 0)
        {
            $this->region = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_region.id,tg_region.name')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-6 day',strtotime(date_now()))))
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
            $this->region = [];
            $r_array[] = (object) array();
            $regions = Region::all();
            $orders = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_order.id as ord_id,tg_region.id as reg_id')
                    ->whereDate('tg_productssold.created_at','=',date('Y-m-d',strtotime('-5 day',strtotime(date_now()))))
                    ->join('tg_order','tg_order.id','tg_productssold.order_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->groupBy('ord_id','reg_id')->get();
                    foreach ($regions as $r => $region) {
                        $i=0;
                         $sum=0;
                        foreach ($orders as $o => $order) {
                            if($region->id == $order->reg_id)
                            {
                                $i += 1;
                                $sum += $order->allprice;
                            }
                        }
                        if($i != 0)
                            {
                                $this->region[] = array('allprice' => number_format($sum/$i,2),'name' => $region->name,'id' => $region->id);
                            }
                    }
        }
        return view('livewire.counter');
    }
}
