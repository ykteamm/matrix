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
    
    public $qizil = 0;
    public $sariq = 0;
    public $yashil = 0;

    public $qizil_sum = 0;
    public $sariq_sum = 0;
    public $yashil_sum = 0;

    public $qarz;

    public function mount()
    {

        


        $money = new AdminService;

        $dd = $money->orderMoneyArrive();

        // dd($dd);

        $this->arrive_monay = $money->arriveMoney();


        $this->arrive_monay_day = $money->arriveMoneyToday();
        $this->arrive_monay_week = $money->arriveMoneyWeek();

        $this->shipment = $money->shipment();
        $this->shipment_day = $money->shipmentDay();
        $this->shipment_week = $money->shipmentWeek();

        

        $this->qarz = $money->qarz();

        foreach ($money->rek() as $key => $value) {
            if($value['con'] == 0)
            {
                $this->qizil += 1;
                $this->qizil_sum += $value['sum'];
            }
            if($value['con'] == 1)
            {
                $this->sariq += 1;
                $this->sariq_sum += $value['sum'];
            }
            if($value['con'] == 2)
            {
                $this->yashil += 1;
                $this->yashil_sum += $value['sum'];
            }
        }

    }

    public function render()
    {
        return view('livewire.admin');
    }
}
