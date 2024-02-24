<?php

namespace App\Http\Livewire;

use App\Models\Calendar;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use App\Models\Pharmacy;
use App\Models\Region;
use App\Models\Bron;
use App\Services\McReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class McReport extends Component
{
    public $pharmacy;
    public $regions;

    public $bron_olish = [];
    public $brons = [];

    public $razgavor = [];
    public $razgavor_brons = [];

    public $otkaz = [];
    public $otkaz_brons = [];

    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {

        $this->pharmacy = Pharmacy::orderBy('name','ASC')->get();
        $reg = Region::orderBy('name','ASC')->get();
        $this->regions = Region::orderBy('name','ASC')->get();
        $brons = Bron::all();

        foreach($reg as $k => $v)
        {
            $this->bron_olish[$v->id] = 0;
            $this->razgavor[$v->id] = 0;
            $this->otkaz[$v->id] = 0;

            foreach($brons as $b => $t)
            {
                $ph = Pharmacy::find($t->pharmacy_id);
                if($ph->region_id == $v->id)
                {
                    if ($t->status == 1) {
                        $this->bron_olish[$v->id] += $t->bron_puli;
                        $this->brons[$v->id][] = $t;
                    }
                    if ($t->status == 2) {
                        $this->razgavor[$v->id] += $t->bron_puli;
                        $this->razgavor_brons[$v->id][] = $t;
                    }
                    if ($t->status == 3) {
                        $this->otkaz[$v->id] += $t->bron_puli;
                        $this->otkaz_brons[$v->id][] = $t;
                    }


                }
            }
        }



        // dd($this->bron_olish,$this->brons);
    }

    public function status1($id)
    {
        $update = Bron::find($id);
        $update->status = 2;
        $update->save();
        $this->redirect('report');
    }

    public function status0($id)
    {
        $update = Bron::find($id);
        $update->status = 1;
        $update->save();
        $this->redirect('report');
    }
    public function status3($id)
    {
        $update = Bron::find($id);
        $update->status = 3;
        $update->save();
        $this->redirect('report');
    }





    public function getFirstDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->firstOfMonth()
                        ->format('Y-m-d');
        return $d;
    }

    public function getLastDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        return $d;
    }

    public function render()
    {
        return view('livewire.mc-report');
    }
}
