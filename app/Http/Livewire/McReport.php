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
    public $active_region;

    public $active_month;

    public $otgruzka = [];
    public $last_close_money = [];
    public $new_close_money = [];

    protected $listeners = [
        'change_Region' => 'changeRegion',
    ];

    public function mount()
    {
        $this->regions = Region::all();
        $this->active_month = date('Y-m'.'-01');
        
        foreach ($this->regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$this->active_month)
            ->pluck('id')->toArray();

            $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$this->active_month)
            ->pluck('id')->toArray();

            $this->otgruzka[$region->id] = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$this->active_month)
            ->sum('price');

            $this->last_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$close_order_ids)
            ->sum('amount');

            $this->new_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$new_order_ids)
            ->sum('amount');
        }
        $this->active_region = 'Hammasi';
    }

    public function changeRegion($idOrAll)
    {
        if($idOrAll == 'all')
        {
            $this->active_region = 'Hammasi';
        }else{
            $this->active_region = Region::find($idOrAll)->name;
        }
    }

    public function render()
    {
        return view('livewire.mc-report');
    }
}
