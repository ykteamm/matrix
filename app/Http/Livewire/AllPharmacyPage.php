<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Region;
use App\Services\RmService;

class AllPharmacyPage extends Component
{
    public $regions;
    public $times = 'today';
    public $time_text = 'Bugun';
    public $region_id;
    public $region_name = 'Barchasi';

    public function region($id,$text)
    {
        $this->region_id = $id;
        $this->region_name = $text;
    }
    public function times($date,$text)
    {
        $this->times = $date;
        $this->time_text = $text;
    }
    public function render()
    {
        $t = rmDay();
        if($t == 1)
        {
            $this->times = 'last';
            $this->time_text = 'Kecha';
        }else{
            $this->times = 'today';
            $this->time_text = 'Bugun';
        }
        if($this->region_id)
        {
            $id[] = $this->region_id;
        }else{
            $id = getRegion();
        }
        $regionId = getRegion();
        $this->regions = Region::whereIn('id',$regionId)->get();
        $u = new RmService;
        $this->pharmacy = $u->allPharmacy($this->times,$id);
        return view('livewire.all-pharmacy-page');
    }
}
