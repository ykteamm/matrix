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
    public $regions = [];
    public $brons;


    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {
        
        $this->pharmacy = Pharmacy::orderBy('name','ASC')->get();
        $reg = Region::orderBy('name','ASC')->get();
        foreach($reg as $k => $v)
        {
            $this->regions[$v->id] = Bron::where('pharmacy_id',$v->id)->sum('bron_puli');
        }
        // $this->brons = Bron::all();
        dd($this->regions);
    }

    public function changeMonth($month)
    {
        $this->active_month = date('Y-m'.'-01',strtotime('01.'.$month));

        if($this->active_month == '2023-07-01')
        {
            $this->hisobot($this->regions,$this->active_month);
        }
        else{
            $this->hisobotMonth($this->regions,$this->active_month);
        }


    }

    public function hisobotMonth1($regions,$active_month)
    {
        $this->all_money[1] = 0;
        $this->otgruzka[1] = 0;
        $this->last_close_money[1] = 0;
        $this->last_accept_money[1] = 0;
        $this->new_close_money[1] = 0;
        $this->new_accept_money[1] = 0;
        $this->predoplata[1] = 0;
        $this->product_accept[1] = 0;

        $this->all_money[2] = 80068000;
        $this->otgruzka[2] = 153833050;
        $this->last_close_money[2] = 0;
        $this->last_accept_money[2] = 29837338;
        $this->new_close_money[2] = 80068000;
        $this->new_accept_money[2] = 52593794;
        $this->predoplata[2] = 0;
        $this->product_accept[2] = 0;

        $this->all_money[3] = 32526500;
        $this->otgruzka[3] = 74207400;
        $this->last_close_money[3] = 5000000;
        $this->last_accept_money[3] = 7910579;
        $this->new_close_money[3] = 27526500;
        $this->new_accept_money[3] = 42759534;
        $this->predoplata[3] = 0;
        $this->product_accept[3] = 0;

        $this->all_money[4] = 0;
        $this->otgruzka[4] = 0;
        $this->last_close_money[4] = 0;
        $this->last_accept_money[4] = 0;
        $this->new_close_money[4] = 0;
        $this->new_accept_money[4] = 0;
        $this->predoplata[4] = 0;
        $this->product_accept[4] = 0;

        $this->all_money[5] = 66987000;
        $this->otgruzka[5] = 131368110;
        $this->last_close_money[5] = 40606665;
        $this->last_accept_money[5] = 77975222;
        $this->new_close_money[5] = 26380335;
        $this->new_accept_money[5] = 104987775;
        $this->predoplata[5] = 0;
        $this->product_accept[5] = 0;

        $this->all_money[6] = 0;
        $this->otgruzka[6] = 0;
        $this->last_close_money[6] = 0;
        $this->last_accept_money[6] = 0;
        $this->new_close_money[6] = 0;
        $this->new_accept_money[6] = 0;
        $this->predoplata[6] = 0;
        $this->product_accept[6] = 0;

        $this->all_money[7] = 59709275;
        $this->otgruzka[7] = 107902450;
        $this->last_close_money[7] = 28056275;
        $this->last_accept_money[7] = 26061550;
        $this->new_close_money[7] = 31653000;
        $this->new_accept_money[7] = 76249450;
        $this->predoplata[7] = 0;
        $this->product_accept[7] = 0;

        $this->all_money[8] = 97021390;
        $this->otgruzka[8] = 77070020;
        $this->last_close_money[8] = 92317790;
        $this->last_accept_money[8] = 132198641;
        $this->new_close_money[8] = 4703600;
        $this->new_accept_money[8] = 72366420;
        $this->predoplata[8] = 0;
        $this->product_accept[8] = 0;

        $this->all_money[9] = 6100000;
        $this->otgruzka[9] = 12721705;
        $this->last_close_money[9] = 6100000;
        $this->last_accept_money[9] = 14456800;
        $this->new_close_money[9] = 0;
        $this->new_accept_money[9] = 12721705;
        $this->predoplata[9] = 0;
        $this->product_accept[9] = 0;

        $this->all_money[10] = 0;
        $this->otgruzka[10] = 0;
        $this->last_close_money[10] = 0;
        $this->last_accept_money[10] = 0;
        $this->new_close_money[10] = 0;
        $this->new_accept_money[10] = 0;
        $this->predoplata[10] = 0;
        $this->product_accept[10] = 0;

        $this->all_money[11] = 0;
        $this->otgruzka[11] = 0;
        $this->last_close_money[11] = 0;
        $this->last_accept_money[11] = 0;
        $this->new_close_money[11] = 0;
        $this->new_accept_money[11] = 0;
        $this->predoplata[11] = 0;
        $this->product_accept[11] = 0;

        $this->all_money[12] = 12443725;
        $this->otgruzka[12] = 64572583;
        $this->last_close_money[12] = 11686413;
        $this->last_accept_money[12] = 51551842;
        $this->new_close_money[12] = 757312;
        $this->new_accept_money[12] = 63556121;
        $this->predoplata[12] = 0;
        $this->product_accept[12] = 0;

        $this->all_money[13] = 19303975;
        $this->otgruzka[13] = 36267200;
        $this->last_close_money[13] = 11077613;
        $this->last_accept_money[13] = 15706606;
        $this->new_close_money[13] = 8226362;
        $this->new_accept_money[13] = 25076838;
        $this->predoplata[13] = 0;
        $this->product_accept[13] = 0;

        $this->all_money[14] = 27153200;
        $this->otgruzka[14] = 39976575;
        $this->last_close_money[14] = 6827900;
        $this->last_accept_money[14] = 15780051;
        $this->new_close_money[14] = 20325300;
        $this->new_accept_money[14] = 19651275;
        $this->predoplata[14] = 0;
        $this->product_accept[14] = 0;

        $this->all_money[15] = 0;
        $this->otgruzka[15] = 0;
        $this->last_close_money[15] = 0;
        $this->last_accept_money[15] = 0;
        $this->new_close_money[15] = 0;
        $this->new_accept_money[15] = 0;
        $this->predoplata[15] = 0;
        $this->product_accept[15] = 0;

        $this->all_money[16] = 0;
        $this->otgruzka[16] = 0;
        $this->last_close_money[16] = 0;
        $this->last_accept_money[16] = 0;
        $this->new_close_money[16] = 0;
        $this->new_accept_money[16] = 0;
        $this->predoplata[16] = 0;
        $this->product_accept[16] = 0;

        $this->all_money[17] = 45000000;
        $this->otgruzka[17] = 64014350;
        $this->last_close_money[17] = 45000000;
        $this->last_accept_money[17] = 79627956;
        $this->new_close_money[17] = 0;
        $this->new_accept_money[17] = 64014350;
        $this->predoplata[17] = 0;
        $this->product_accept[17] = 0;

        $this->all_money[18] = 197907598;
        $this->otgruzka[18] = 179253100;
        $this->last_close_money[18] = 170331898;
        $this->last_accept_money[18] = 12591818;
        $this->new_close_money[18] = 27575700;
        $this->new_accept_money[18] = 151677400;
        $this->predoplata[18] = 0;
        $this->product_accept[18] = 0;

        $this->all_money[19] = 0;
        $this->otgruzka[19] = 0;
        $this->last_close_money[19] = 0;
        $this->last_accept_money[19] = 21894258;
        $this->new_close_money[19] = 0;
        $this->new_accept_money[19] = 0;
        $this->predoplata[19] = 0;
        $this->product_accept[19] = 0;

        $this->all_money[20] = 1726660;
        $this->otgruzka[20] = 0;
        $this->last_close_money[20] = 1726660;
        $this->last_accept_money[20] = 941050;
        $this->new_close_money[20] = 0;
        $this->new_accept_money[20] = 0;
        $this->predoplata[20] = 0;
        $this->product_accept[20] = 0;

        $this->all_money[21] = 0;
        $this->otgruzka[21] = 0;
        $this->last_close_money[21] = 0;
        $this->last_accept_money[21] = 3511900;
        $this->new_close_money[21] = 0;
        $this->new_accept_money[21] = 0;
        $this->predoplata[21] = 0;
        $this->product_accept[21] = 0;

        $this->all_money[22] = 0;
        $this->otgruzka[22] = 0;
        $this->last_close_money[22] = 0;
        $this->last_accept_money[22] = 0;
        $this->new_close_money[22] = 0;
        $this->new_accept_money[22] = 0;
        $this->predoplata[22] = 0;
        $this->product_accept[22] = 0;

        $this->all_money[23] = 0;
        $this->otgruzka[23] = 0;
        $this->last_close_money[23] = 0;
        $this->last_accept_money[23] = 1003800;
        $this->new_close_money[23] = 0;
        $this->new_accept_money[23] = 0;
        $this->predoplata[23] = 0;
        $this->product_accept[23] = 0;
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
