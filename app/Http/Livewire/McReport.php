<?php

namespace App\Http\Livewire;

use App\Models\Calendar;
use App\Models\McOrder;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\Pharmacy;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class McReport extends Component
{
    public $regions;
    public $months;
    public $regions_all;
    public $active_region = 'Hammasi';
    public $active_region_id = 'All';

    public $active_month;

    public $otgruzka = [];
    public $last_close_money = [];
    public $last_accept_money = [];
    public $new_close_money = [];
    public $new_accept_money = [];
    public $predoplata = [];
    public $product_accept = [];
    public $all_money = [];



    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {

        $this->regions_all = Region::all();
        $this->regions = Region::all();
        $this->months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');

        $this->active_month = date('Y-m'.'-01');
        $this->active_region = 'Hammasi';
        
        $this->hisobot($this->regions_all,$this->active_month);
    }

    public function changeRegion($idOrAll)
    {
        if($idOrAll == 'all')
        {
            $this->active_region = 'Hammasi';
            $this->regions = Region::all();

        }else{
            $this->active_region = Region::find($idOrAll)->name;
            $this->regions = Region::where('id',$idOrAll)->get();
        }

        $this->hisobot($this->regions,$this->active_month);

    }

    public function changeMonth($month)
    {
        $this->active_month = date('Y-m'.'-01',strtotime('01.'.$month));
        $this->hisobot($this->regions,$this->active_month);

    }

    public function hisobot($regions,$active_month)
    {
        foreach ($regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->where('price','!=',null)
            ->whereDate('order_date','<',$active_month)
            ->pluck('id')->toArray();

            $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->where('price','!=',null)
            ->pluck('id')->toArray();

            $all_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->where('price','!=',null)
            ->pluck('id')->toArray();

            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->where('price','=',NULL)
            ->pluck('id')->toArray();

            $ords = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->get();
            $ords_sum = 0;
            foreach ($ords as $key => $value) {
                $ords_sum += $value->price - $value->price*$value->discount/100;
            }

            $this->otgruzka[$region->id] = $ords_sum;

            // ->sum(DB::raw('price-(price*discount/100)'));

            $this->last_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$close_order_ids)
            ->sum('amount');

            $ords = McOrder::whereIn('id',$close_order_ids)
            ->get();
            $ords_sum = 0;
            foreach ($ords as $key => $value) {
                $ords_sum += $value->price - $value->price*$value->discount/100;
            }

            $this->last_accept_money[$region->id] = $ords_sum-$this->last_close_money[$region->id];

            // $this->last_accept_money[$region->id] = McOrder::whereIn('id',$close_order_ids)
            // ->sum('price')-$this->last_close_money[$region->id];

            if($this->last_accept_money[$region->id] < 0)
            {
                $this->last_accept_money[$region->id] = 0;
            }

            $this->new_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$new_order_ids)
            ->sum('amount');

            $ords = McOrder::whereIn('id',$new_order_ids)
            ->get();
            $ords_sum = 0;
            foreach ($ords as $key => $value) {
                $ords_sum += $value->price - $value->price*$value->discount/100;
            }

            $this->new_accept_money[$region->id] = $ords_sum-$this->new_close_money[$region->id];

            // $this->new_accept_money[$region->id] = McOrder::whereIn('id',$new_order_ids)
            // ->sum('price')-$this->new_close_money[$region->id];

            if($this->new_accept_money[$region->id] < 0)
            {
                $this->new_accept_money[$region->id] = 0;
            }

            $this->predoplata[$region->id] = McPaymentHistory::whereIn('order_id',$pred_order_ids)
            ->sum('amount');

            $this->product_accept[$region->id] = McOrderDetail::whereIn('order_id',$new_order_ids)
            ->sum(DB::raw('debt*price'));

            $this->all_money[$region->id] = McPaymentHistory::whereIn('order_id',$all_order_ids)
            ->sum('amount');
        }
    }

    public function render()
    {
        return view('livewire.mc-report');
    }
}
