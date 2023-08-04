<?php

namespace App\Http\Livewire;

use App\Models\McOrder;
use App\Models\McPaymentHistory;
use App\Models\Pharmacy;
use App\Models\Region;
use Livewire\Component;

class McReport extends Component
{
    public $regions;
    public $regions_all;
    public $active_region = 'Hammasi';
    public $active_region_id = 'All';

    public $active_month;

    public $otgruzka = [];
    public $last_close_money = [];
    public $last_accept_money = [];
    public $new_close_money = [];
    public $new_accept_money = [];
    public $all_money = [];



    protected $listeners = [
        'change_Region' => 'changeRegion',
    ];

    public function mount()
    {

        if($this->active_region_id == 'All')
        {
            $this->regions = Region::all();
        }else{
            $this->regions = Region::where('id',$this->active_region_id)->get();
        }

        $this->regions_all = Region::all();


        $this->active_month = date('Y-m'.'-01');
        $this->active_region = 'Hammasi';
        
        foreach ($this->regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$this->active_month)
            ->pluck('id')->toArray();

            $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$this->active_month)
            ->pluck('id')->toArray();

            $all_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->pluck('id')->toArray();

            $this->otgruzka[$region->id] = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$this->active_month)
            ->sum('price');

            $this->last_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$close_order_ids)
            ->sum('amount');

            $this->last_accept_money[$region->id] = McOrder::whereIn('id',$close_order_ids)
            ->sum('price')-$this->last_close_money[$region->id];

            $this->new_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$new_order_ids)
            ->sum('amount');

            $this->new_accept_money[$region->id] = McOrder::whereIn('id',$new_order_ids)
            ->sum('price')-$this->new_close_money[$region->id];

            $this->all_money[$region->id] = McPaymentHistory::whereIn('order_id',$all_order_ids)
            ->sum('amount');
        }
    }

    public function changeRegion($idOrAll)
    {
        if($idOrAll == 'all')
        {
            $this->active_region = 'Hammasi';
            $this->active_region_id = 'All';
        }else{
            $this->active_region = Region::find($idOrAll)->name;
            $this->active_region_id = $idOrAll;
        }
        $this->mount(); 
    }

    public function render()
    {
        return view('livewire.mc-report');
    }
}
