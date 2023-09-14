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
use App\Services\McReportService;
use Carbon\Carbon;
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
    public $predoplata_new = [];
    public $product_accept = [];
    public $all_money = [];



    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {
        // $this->active_month = date('2023-08-01');

        // $report = new McReportService($this->active_month);

        // $last_money = $report->lastMoney();

        // dd($last_money);
        $this->regions_all = Region::all();
        $this->regions = Region::all();
        $this->months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');

        $this->active_month = date('2023-08-01');
        $this->active_region = 'Hammasi';
        
        if($this->active_month == '2023-07-01')
        {
            $this->hisobot($this->regions_all,$this->active_month);
        }
        else{
            $this->hisobotMonth($this->regions_all,$this->active_month);
        }

    }

    // public function changeRegion($idOrAll)
    // {
    //     if($idOrAll == 'all')
    //     {
    //         $this->active_region = 'Hammasi';
    //         $this->regions = Region::all();

    //     }else{
    //         $this->active_region = Region::find($idOrAll)->name;
    //         $this->regions = Region::where('id',$idOrAll)->get();
    //     }

    //     if($this->active_month == '2023-07-01')
    //     {
    //         $this->hisobot($this->regions,$this->active_month);
    //     }elseif($this->active_month == '2023-08-01')
    //     {
    //         $this->hisobotMonth222222($this->regions,$this->active_month);
    //     }
    //     else{
    //         $this->hisobotMonth($this->regions,$this->active_month);
    //     }


    // }

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

    public function hisobotMonth222222($regions,$active_month)
    { 
        $this->all_money[1] = 0;
        $this->otgruzka[1] = 0;
        $this->last_close_money[1] = 0;
        $this->last_accept_money[1] = 0;
        $this->new_close_money[1] = 0;
        $this->new_accept_money[1] = 0;
        $this->predoplata[1] = 0;
        $this->product_accept[1] = 0;

        $this->all_money[2] = 138840000;
        $this->otgruzka[2] = 175294650;
        $this->last_close_money[2] = 0;
        $this->last_accept_money[2] = 29837338;
        $this->new_close_money[2] = 138840000;                                                                                                                                                              
        $this->new_accept_money[2] = 16641390;
        $this->predoplata[2] = 0;
        $this->product_accept[2] = 0;

        $this->all_money[3] = 56916500;
        $this->otgruzka[3] = 82569975;
        $this->last_close_money[3] = 8000000;
        $this->last_accept_money[3] = 4910579;
        $this->new_close_money[3] = 48916500;
        $this->new_accept_money[3] = 29732109;
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

        $this->all_money[5] = 123681300;
        $this->otgruzka[5] = 146056710;
        $this->last_close_money[5] = 49936315;
        $this->last_accept_money[5] = 68645572;
        $this->new_close_money[5] = 73744985;
        $this->new_accept_money[5] = 73703935;
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

        $this->all_money[7] = 78586575;
        $this->otgruzka[7] = 112606450;
        $this->last_close_money[7] = 28056275;
        $this->last_accept_money[7] = 26061550;
        $this->new_close_money[7] = 50530300;
        $this->new_accept_money[7] = 62876150;
        $this->predoplata[7] = 0;
        $this->product_accept[7] = 0;

        $this->all_money[8] = 110012546;
        $this->otgruzka[8] = 88782370;
        $this->last_close_money[8] = 105308946;
        $this->last_accept_money[8] = 119207485;
        $this->new_close_money[8] = 4703600;
        $this->new_accept_money[8] = 84078770;
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

        $this->all_money[12] = 47041425;
        $this->otgruzka[12] = 72604083;
        $this->last_close_money[12] = 46284113;
        $this->last_accept_money[12] = 16954142;
        $this->new_close_money[12] = 757312;
        $this->new_accept_money[12] = 71587621;
        $this->predoplata[12] = 0;
        $this->product_accept[12] = 0;
       
        $this->all_money[13] = 26303975;
        $this->otgruzka[13] = 39711200;
        $this->last_close_money[13] = 18077613;
        $this->last_accept_money[13] = 8706606;
        $this->new_close_money[13] = 8226362;
        $this->new_accept_money[13] = 28520838;
        $this->predoplata[13] = 0;
        $this->product_accept[13] = 0;
        
        $this->all_money[14] = 52784200;
        $this->otgruzka[14] = 45092400;
        $this->last_close_money[14] = 6827900;
        $this->last_accept_money[14] = 15780051;
        $this->new_close_money[14] = 45956300;
        $this->new_accept_money[14] = 0;
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

        $this->all_money[17] = 82571350;
        $this->otgruzka[17] = 64014350;
        $this->last_close_money[17] = 82571350;
        $this->last_accept_money[17] = 42056606;
        $this->new_close_money[17] = 0;
        $this->new_accept_money[17] = 64014350;
        $this->predoplata[17] = 0;
        $this->product_accept[17] = 0;

        $this->all_money[18] = 197907598;
        $this->otgruzka[18] = 201077700;
        $this->last_close_money[18] = 170331898;
        $this->last_accept_money[18] = 12591818;
        $this->new_close_money[18] = 27575700;
        $this->new_accept_money[18] = 173502000;
        $this->predoplata[18] = 0;
        $this->product_accept[18] = 0;

        $this->all_money[19] = 1400000;
        $this->otgruzka[19] = 0;
        $this->last_close_money[19] = 1400000;
        $this->last_accept_money[19] = 20374258;
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

        $this->all_money[21] = 1457750;
        $this->otgruzka[21] = 0;
        $this->last_close_money[21] = 1457750;
        $this->last_accept_money[21] = 0;
        $this->new_close_money[21] = 0;
        $this->new_accept_money[21] = 0;
        $this->predoplata[21] = 0;
        $this->product_accept[21] = 0;

        $this->all_money[22] = 1457750;
        $this->otgruzka[22] = 0;
        $this->last_close_money[22] = 1457750;
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

    public function hisobot1($regions,$active_month)
    { 
        $this->all_money[1] = 0;
        $this->otgruzka[1] = 0;
        $this->last_close_money[1] = 0;
        $this->last_accept_money[1] = 0;
        $this->new_close_money[1] = 0;
        $this->new_accept_money[1] = 0;
        $this->predoplata[1] = 0;
        $this->product_accept[1] = 0;

        $this->all_money[2] = 75008996;
        $this->otgruzka[2] = 63755536;
        $this->last_close_money[2] = 0;
        $this->last_accept_money[2] = 20586802;
        $this->new_close_money[2] = 75008996;
        $this->new_accept_money[2] = 9250536;
        $this->predoplata[2] = 0;
        $this->product_accept[2] = 0;

        $this->all_money[3] = 67640000;
        $this->otgruzka[3] = 36576475;
        $this->last_close_money[3] = 26675659;
        $this->last_accept_money[3] = 12910579;
        $this->new_close_money[3] = 40964341;
        $this->new_accept_money[3] = 0;
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

        $this->all_money[5] = 115532985;
        $this->otgruzka[5] = 119868160;
        $this->last_close_money[5] = 33662265;
        $this->last_accept_money[5] = 79154447;
        $this->new_close_money[5] = 81870720;
        $this->new_accept_money[5] = 37661440;
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

        $this->all_money[7] = 70987000;
        $this->otgruzka[7] = 88068100;
        $this->last_close_money[7] = 37857775;
        $this->last_accept_money[7] = 1533550;
        $this->new_close_money[7] = 33129225;
        $this->new_accept_money[7] = 52584275;
        $this->predoplata[7] = 0;
        $this->product_accept[7] = 0;

        $this->all_money[8] = 147644041;
        $this->otgruzka[8] = 85136488;
        $this->last_close_money[8] = 143895436;
        $this->last_accept_money[8] = 136319319;
        $this->new_close_money[8] = 3748605;
        $this->new_accept_money[8] = 81387883;
        $this->predoplata[8] = 0;
        $this->product_accept[8] = 0;

        $this->all_money[9] = 5133000;
        $this->otgruzka[9] = 7748550;
        $this->last_close_money[9] = 5133000;
        $this->last_accept_money[9] = 12808250;
        $this->new_close_money[9] = 0;
        $this->new_accept_money[9] = 7748550;
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

        $this->all_money[12] = 43925687;
        $this->otgruzka[12] = 55923838;
        $this->last_close_money[12] = 9925687;
        $this->last_accept_money[12] = 41055267;
        $this->new_close_money[12] = 34000000;
        $this->new_accept_money[12] = 22182988;
        $this->predoplata[12] = 0;
        $this->product_accept[12] = 0;
       
        $this->all_money[13] = 60051400;
        $this->otgruzka[13] = 54051600;
        $this->last_close_money[13] = 10586400;
        $this->last_accept_money[13] = 17407581;
        $this->new_close_money[13] = 49465000;
        $this->new_accept_money[13] = 9376638;
        $this->predoplata[13] = 0;
        $this->product_accept[13] = 0;
        
        $this->all_money[14] = 66407747;
        $this->otgruzka[14] = 64624665;
        $this->last_close_money[14] = 15156782;
        $this->last_accept_money[14] = 9234251;
        $this->new_close_money[14] = 51250965;
        $this->new_accept_money[14] = 13373700;
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

        $this->all_money[17] = 51000000;
        $this->otgruzka[17] = 93210088;
        $this->last_close_money[17] = 41000000;
        $this->last_accept_money[17] = 41417868;
        $this->new_close_money[17] = 10000000;
        $this->new_accept_money[17] = 83210088;
        $this->predoplata[17] = 0;
        $this->product_accept[17] = 0;

        $this->all_money[18] = 193813498;
        $this->otgruzka[18] = 228066900;
        $this->last_close_money[18] = 133813498;
        $this->last_accept_money[18] = 14856816;
        $this->new_close_money[18] = 60000000;
        $this->new_accept_money[18] = 168066900;
        $this->predoplata[18] = 0;
        $this->product_accept[18] = 0;

        $this->all_money[19] = 0;
        $this->otgruzka[19] = 0;
        $this->last_close_money[19] = 0;
        $this->last_accept_money[19] = 22844658;
        $this->new_close_money[19] = 0;
        $this->new_accept_money[19] = 0;
        $this->predoplata[19] = 0;
        $this->product_accept[19] = 0;

        $this->all_money[20] = 0;
        $this->otgruzka[20] = 0;
        $this->last_close_money[20] = 0;
        $this->last_accept_money[20] = 4473715;
        $this->new_close_money[20] = 0;
        $this->new_accept_money[20] = 0;
        $this->predoplata[20] = 0;
        $this->product_accept[20] = 0;

        $this->all_money[21] = 0;
        $this->otgruzka[21] = 0;
        $this->last_close_money[21] = 0;
        $this->last_accept_money[21] = 6206600;
        $this->new_close_money[21] = 0;
        $this->new_accept_money[21] = 0;
        $this->predoplata[21] = 0;
        $this->product_accept[21] = 0;

        $this->all_money[22] = 0;
        $this->otgruzka[22] = 0;
        $this->last_close_money[22] = 0;
        $this->last_accept_money[22] = 10835899;
        $this->new_close_money[22] = 0;
        $this->new_accept_money[22] = 0;
        $this->predoplata[22] = 0;
        $this->product_accept[22] = 0;
        
        $this->all_money[23] = 0;
        $this->otgruzka[23] = 0;
        $this->last_close_money[23] = 0;
        $this->last_accept_money[23] = 7813030;
        $this->new_close_money[23] = 0;
        $this->new_accept_money[23] = 0;
        $this->predoplata[23] = 0;
        $this->product_accept[23] = 0;
    }

    public function hisobotMonth($regions,$active_month)
    {
        
        
        $report = new McReportService($active_month);

        foreach ($regions as $key => $region) {

            // $pharmacy_ids = Pharmacy::where('region_id',3)->pluck('id')->toArray();
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            
            $this->last_close_money = $report->lastCloseMoney($region->id,$pharmacy_ids);
            $this->last_accept_money = $report->lastAcceptMoney($region->id,$pharmacy_ids);

            $this->new_close_money = $report->newCloseMoney($region->id,$pharmacy_ids);
            $this->new_accept_money = $report->newAcceptMoney($region->id,$pharmacy_ids);

            $this->predoplata = $report->predoplata($region->id,$pharmacy_ids);

            $this->predoplata_new = $report->predoplataNew($region->id,$pharmacy_ids);

            
            $this->all_money[$region->id] = $this->last_close_money[$region->id] + $this->new_close_money[$region->id];

            $this->otgruzka[$region->id] = $this->new_close_money[$region->id] + $this->new_accept_money[$region->id] + $this->predoplata[$region->id]-$this->predoplata_new[$region->id];
            
            $this->product_accept[$region->id] = 0;

        }

        // dd($this->new_close_money);

        
    }

    public function hisobotMonth321($regions,$active_month)
    {
        $last_month = $this->getFirstDate(date('Y-m-d',strtotime('-1 month',strtotime($active_month))));

        $last_active_month = $this->getLastDate($active_month);
        
        $report = new McReportService;

        foreach ($regions as $key => $region) {

            // $pharmacy_ids = Pharmacy::where('region_id',12)->pluck('id')->toArray();
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            
            $last_money = $report->lastMoney($region->id);
            

        //predoplata-begin
            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->whereDate('order_date','>=',$last_month)
            ->get();
            $sum1 = 0;
            $sum2 = 0;
            $pred2 = [];
            foreach ($pred_order_ids as $key => $value) {

                if($value->price == NULL)
                {
                    $sum1 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');

                    $sum2 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');
                }else{
                    $ord_det = McOrderDetail::where('order_id',$value->id)->orderBy('id','ASC')->first();
                    $ord_sum = McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')->first();
                    if($ord_sum && $ord_det)
                    {
                        if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                        {
                            $sum1 += $ord_sum->amount;
                        }
                    }
                }


            }

            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            ->whereDate('order_date','>=',$active_month)
            ->get();
            $sum4 = 0;
            $pred3 = [];
            foreach ($pred_order_ids as $key => $value) {

                if($value->price == NULL)
                {

                    $sum4 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');
                }
            }

            $this->predoplata[$region->id] = $sum1;
            $pred2[$region->id] = $sum2;
            $pred3[$region->id] = $sum4;

        //predoplata-end
                   
        //kelganpul-begin
            $all_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            ->pluck('id')->toArray();

            $sum1 = 0;
            $sum2 = 0;
            foreach($all_order_ids as $value)
            {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();

                $sum = McPaymentHistory::where('order_id',$value)
                ->whereDate('created_at','<=',$last_active_month)
                ->whereDate('created_at','>=',$active_month)
                ->sum('amount');
               
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $sum1 += $sum;
                        }else{
                                $sum1 += $sum;
                        }
                    }else{
                        $sum1 += $sum;
                    }
                    
                }
                
            }

            $this->all_money[$region->id] = $sum1;
        //kelganpul-end

        //otgruzga-begin-
            $ords = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            ->get();
            $s = 0;
            foreach ($ords as $key => $value) {
                $mc_del = McOrderDelivery::where('order_id',$value->id)
                ->whereDate('created_at','>=',$active_month)
                ->whereDate('created_at','<=',$last_active_month)
                ->sum(DB::raw('price*quantity'));

                $s += $mc_del - $mc_del*$value->discount/100;
            }
            
            $this->otgruzka[$region->id] = $s;
        //otgruzga-end

        //eski-qarz-yopildi-begin
            $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->orderBy('id','ASC')
            ->pluck('id')->toArray();


            $sum1 = 0;
            $sum133 = [];
            $ords_all_sum = 0;
            foreach ($close_order_ids as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    $sum1 += McPaymentHistory::where('order_id',$value)
                        ->where('last',0)
                        ->whereDate('created_at','>=',$active_month)
                        ->whereDate('created_at','<=',$last_active_month)
                        ->sum('amount');

                }

                $ords_ord = McOrder::find($value);

                $ords = McOrderDelivery::where('order_id',$value)->first();

                if($ords)
                {
                    if(strtotime($ords->created_at) < strtotime($active_month))
                    {
                        $last_qoldi = McPaymentHistory::where('order_id',$value)->sum('amount');
                        $ords_all_sumff = $ords_ord->price - $ords_ord->price*$ords_ord->discount/100 - $last_qoldi;
                    }
                    
                }else{

                    $last_qoldi = McPaymentHistory::where('order_id',$value)->sum('amount');

                    $vozvrat = McReturnHistory::where('order_id',$value)->sum('amount');

                    $ords_all_sumff = $ords_ord->price - $ords_ord->price*$ords_ord->discount/100 - $last_qoldi-$vozvrat;
                }

                
                

                $sum133[$value] = $ords_all_sumff;

            }



            $this->last_close_money[$region->id] = $sum1;

            $this->last_accept_money[$region->id] =  array_sum($sum133);


        //eski-qarz-yopildi-end



        //yangi-qarz-qoldi-begin

            $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->whereDate('order_date','<=',$last_active_month)
            ->pluck('id')->toArray();

           $sum1 = 0;
            
            foreach ($new_order_ids as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();

                if($ord_sum && $ord_det)
                {
                    if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                    {
                        $sum1 += McPaymentHistory::where('order_id',$value)
                        ->sum('amount');
                    }
                }

                
            }

            $this->new_close_money[$region->id] = $sum1;

            // dd($sum1);

            $new_order_ids2 = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach ($new_order_ids2 as $key => $value) {

                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum && $ord_det)
                {
                    if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                    {
                        $e_date = date('Y-m-d',strtotime($ord_sum->created_at));
                        $f_date = $this->getFirstDate($active_month);
                        $n_date = $this->getLastDate($active_month);

                        $sum1 += McPaymentHistory::where('order_id',$value)
                        // ->where('id','!=',$ord_sum->id)
                        ->whereDate('created_at','>=',$f_date)
                        ->whereDate('created_at','<=',$n_date)
                        ->sum('amount');
                    }
                }

            }

            // $this->new_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$new_order_ids)
            // ->sum('amount')+$sum1;

            $ords_sum = 0;
            $sum1 = 0;
            foreach ($new_order_ids2 as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                        {
                            $ords = McOrder::find($value);
                            $sum1 += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }   
                }
            }

            $ords_sum2 = 0;
            foreach ($new_order_ids as $key => $value) {

                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $ords = McOrder::find($value);
                            $ords_sum2 += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }
                }else{
                    $ords = McOrder::find($value);
                    $ords_sum2 += $ords->price - $ords->price*$ords->discount/100;
                }

                
            }

            $this->new_accept_money[$region->id] = $ords_sum2+$sum1-$this->new_close_money[$region->id]-$this->predoplata[$region->id]+$pred2[$region->id]+$pred3[$region->id];
           

            if($this->new_accept_money[$region->id] < 0)
            {
                $this->new_accept_money[$region->id] = 0;
            }

            $this->product_accept[$region->id] = McOrderDetail::whereIn('order_id',$new_order_ids)
            ->sum(DB::raw('debt*price'));
        //yangi-qarz-qoldi-end

        }
        
        dd($last_money);

    }

    public function hisobot($regions,$active_month)
    {
        // $active_month = '2023-07-01';
        $last_month = $this->getFirstDate(date('Y-m-d',strtotime('-1 month',strtotime($active_month))));

        $last_active_month = $this->getLastDate($active_month);
        

        foreach ($regions as $key => $region) {
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();

            

            

        //predoplata-begin
            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->whereDate('order_date','>=',$last_month)
            ->get();
            $sum1 = 0;
            $sum2 = 0;
            $pred2 = [];
            foreach ($pred_order_ids as $key => $value) {

                if($value->price == NULL)
                {
                    $sum1 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');

                    $sum2 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');
                }else{
                    $ord_det = McOrderDetail::where('order_id',$value->id)->orderBy('id','ASC')->first();
                    $ord_sum = McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')->first();
                    if($ord_sum && $ord_det)
                    {
                        if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                        {
                            $sum1 += $ord_sum->amount;
                        }
                    }
                }


            }

            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            ->whereDate('order_date','>=',$active_month)
            ->get();
            $sum4 = 0;
            $pred3 = [];
            foreach ($pred_order_ids as $key => $value) {

                if($value->price == NULL)
                {

                    $sum4 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');
                }
            }

            $this->predoplata[$region->id] = $sum1;
            $pred2[$region->id] = $sum2;
            $pred3[$region->id] = $sum4;

        //predoplata-end
        
       
            

        //kelganpul-begin
            $all_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            // ->whereDate('order_date','>=',$last_month)
            // ->where('price','!=',null)
            ->pluck('id')->toArray();

            $sum1 = 0;
            $sum2 = 0;
            foreach($all_order_ids as $value)
            {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                        {
                            $sum1 += $ord_sum->amount;
                        }
                    }
                    
                }
                $sum2 += McPaymentHistory::where('order_id',$value)->sum('amount');
                
            }

            $this->all_money[$region->id] = $sum2-$sum1-$pred2[$region->id];
        //kelganpul-end

        //otgruzga-begin
            $ords = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->whereDate('order_date','<=',$last_active_month)
            ->get();
            $ords_sum = 0;
            foreach ($ords as $key => $value) {
                $ords_sum += $value->price - $value->price*$value->discount/100;
            }

            $ords = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->whereDate('order_date','>=',$last_month)
            ->get();
            $sum1 = 0;
            foreach ($ords as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value->id)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')->first();
                if($ord_sum && $ord_det)
                {
                    if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                    {
                        $sum1 += $value->price - $value->price*$value->discount/100;
                    }
                }

            }
            $this->otgruzka[$region->id] = $ords_sum + $sum1;
        //otgruzga-end


        //eski-qarz-yopildi-begin
            $close_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<',$active_month)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach ($close_order_ids as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum && $ord_det)
                {
                    if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                    {
                        $e_date = date('Y-m-d',strtotime($ord_sum->created_at));
                        $f_date = $this->getFirstDate($e_date);
                        $n_date = $this->getLastDate($e_date);

                        $sum1 += McPaymentHistory::where('order_id',$value)
                        ->where('id','!=',$ord_sum->id)
                        ->whereDate('created_at','>=',$f_date)
                        ->whereDate('created_at','<=',$n_date)
                        ->sum('amount');
                    }
                }

            }

            $this->last_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$close_order_ids)
            ->sum('amount')-$sum1-$this->predoplata[$region->id];

            $ords_sum = 0;
            foreach ($close_order_ids as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $ords = McOrder::find($value);
                            $ords_sum += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }else{
                        $ords = McOrder::find($value);
                        $ords_sum += $ords->price - $ords->price*$ords->discount/100;
                    }
                }else{
                    $ords = McOrder::find($value);
                    $ords_sum += $ords->price - $ords->price*$ords->discount/100;
                }
            }

            $return = McReturnHistory::whereIn('order_id',$close_order_ids)
            ->sum('amount');
            $this->last_accept_money[$region->id] =  $ords_sum - $return - $this->last_close_money[$region->id];
        
            if($this->last_accept_money[$region->id] < 0)
            {
                $this->last_accept_money[$region->id] = 0;
            }

        //eski-qarz-yopildi-end

        //yangi-qarz-qoldi-begin

            $new_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$active_month)
            ->whereDate('order_date','<=',$last_active_month)
            ->pluck('id')->toArray();


            $new_order_ids2 = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','>=',$last_month)
            ->whereDate('order_date','<',$active_month)
            ->pluck('id')->toArray();

            $sum1 = 0;
            foreach ($new_order_ids2 as $key => $value) {

                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum && $ord_det)
                {
                    if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                    {
                        $e_date = date('Y-m-d',strtotime($ord_sum->created_at));
                        $f_date = $this->getFirstDate($e_date);
                        $n_date = $this->getLastDate($e_date);

                        $sum1 += McPaymentHistory::where('order_id',$value)
                        ->where('id','!=',$ord_sum->id)
                        ->whereDate('created_at','>=',$f_date)
                        ->whereDate('created_at','<=',$n_date)
                        ->sum('amount');
                    }
                }

            }

            $this->new_close_money[$region->id] = McPaymentHistory::whereIn('order_id',$new_order_ids)
            ->sum('amount')+$sum1;

            // $ords = McOrder::whereIn('id',$new_order_ids)
            // ->get();
            // $ords_sum = 0;
            // foreach ($ords as $key => $value) {
            //     $ords_sum += $value->price - $value->price*$value->discount/100;
            // }

            $ords_sum = 0;
            $sum1 = 0;
            foreach ($new_order_ids2 as $key => $value) {
                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
                        {
                            $ords = McOrder::find($value);
                            $sum1 += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }   
                }
            }

            $ords_sum2 = 0;
            foreach ($new_order_ids as $key => $value) {

                $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
                $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
                if($ord_sum)
                {
                    if($ord_det)
                    {
                        if(strtotime($ord_det->created_at) < strtotime($ord_sum->created_at))
                        {
                            $ords = McOrder::find($value);
                            $ords_sum2 += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }
                }else{
                    $ords = McOrder::find($value);
                    $ords_sum2 += $ords->price - $ords->price*$ords->discount/100;
                }

                
            }

            $this->new_accept_money[$region->id] = $ords_sum2+$sum1-$this->new_close_money[$region->id]-$this->predoplata[$region->id]+$pred2[$region->id]+$pred3[$region->id];
           

            if($this->new_accept_money[$region->id] < 0)
            {
                $this->new_accept_money[$region->id] = 0;
            }

            $this->product_accept[$region->id] = McOrderDetail::whereIn('order_id',$new_order_ids)
            ->sum(DB::raw('debt*price'));
        //yangi-qarz-qoldi-end

        }

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
