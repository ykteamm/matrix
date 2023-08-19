<?php

namespace App\Http\Livewire;

use App\Services\AdminService;
use Livewire\Component;

class Admin extends Component
{
    public $arrive_monay;
    public $arrive_monay_day;
    public $arrive_monay_week;

    public $shipment;
    public $shipment_day;
    public $shipment_week;
    
    public function mount()
    {
        $money = new AdminService;

        $this->arrive_monay = $money->arriveMoney();
        $this->arrive_monay_day = $money->arriveMoneyToday();
        $this->arrive_monay_week = $money->arriveMoneyWeek();

        $this->shipment = $money->shipment();
        $this->shipment_day = $money->shipmentDay();
        $this->shipment_week = $money->shipmentWeek();
    }

    public function render()
    {
        return view('livewire.admin');
    }
}
