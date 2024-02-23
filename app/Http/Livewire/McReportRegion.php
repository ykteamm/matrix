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

class McReportRegion extends Component
{
    public $regions;
    public $all_regions;
    public $months;
    public $active_region = 'Qashqadaryo';
    public $active_region_id = 5;

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

    public $ofis_tovar_qarz = [];


    public $yangi_kelgan_pul = [];
    public $eski_kelgan_pul = [];
    public $yangi_qolgan_pul = [];
    public $eski_qolgan_pul = [];
    public $otgan_oy_predoplata = [];
    public $vozvrat = [];
    public $shu_oy_vozvrat = [];
    public $shu_oy_predoplata = [];

    public $pharmacy;

    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {
        $this->regions = Region::all();
        $this->all_regions = Region::all();
        $this->months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');

        $this->active_month = date('2023-11-01');

        $this->active_region_id = Region::pluck('id')->toArray();

        $this->active_region_id = [10,11,14];

        $this->hisobotMonth($this->active_region_id,$this->active_month);

    }


    public function changeMonth($month)
    {
        $this->active_month = date('Y-m'.'-01',strtotime('01.'.$month));


        $this->hisobotMonth($this->active_region_id,$this->active_month);



    }

    public function changeRegion($idOrAll)
    {

        $this->active_region = Region::find($idOrAll)->name;
        $this->active_region_id = [$idOrAll];

        $this->regions = Region::whereIn('id',$this->active_region_id)->get();

        $this->hisobotMonth($this->active_region_id,$this->active_month);


    }

    public function hisobotMonth($region_id,$active_month)
    {

        $this->yangi_kelgan_pul = [];
        $this->eski_kelgan_pul = [];
        $this->yangi_qolgan_pul = [];
        $this->eski_qolgan_pul = [];
        $this->otgan_oy_predoplata = [];
        $this->vozvrat = [];
        $this->shu_oy_vozvrat = [];
        // $region_id = [10,11,14];
        $report = new McReportService($active_month);

        $this->pharmacy = Pharmacy::whereIn('region_id',$region_id)->get();
        // $this->pharmacy = Pharmacy::whereIn('region_id',$region_id)->pluck('name','id');
        // dd($this->pharmacy);
        $testar = [];
        $order_price = [];
        $order_last_price = [];
        $ord_last = [];
        $ord_last_vozvrat = [];
        $ff = [];

        $a1 = [];
        $a2 = [];
        $a3 = [];

        $eski_q_p1 = [];
        $eski_q_p2 = [];
        $eski_q_p3 = [];

        $yan_kel_1 = [];
        $yan_kel_2 = [];

        $ord1 = [];
        $voz1 = [];
        foreach ($this->pharmacy as $key => $value) {

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)->get();
            $this->vozvrat[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    $this->vozvrat[$value->id] += McReturnHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                }

            #shu_oy_vozvrat

                $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
                ->whereDate('order_date','>=',$report->active_month)
                ->whereDate('order_date','<=',$report->last_active_month)
                ->get();
                $this->shu_oy_vozvrat[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    $first_del = McOrderDelivery::where('order_id',$order->id)->orderBy('id','ASC')->first();
                    if($first_del)
                    {
                        if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                        {
                            $first_voz = McReturnHistory::where('order_id',$order->id)->first();
                            if($first_voz)
                            {

                                if(strtotime($report->active_month) <= strtotime($first_voz->created_at) && strtotime($report->last_active_month) >= strtotime($first_voz->created_at))
                                {
                                    $this->shu_oy_vozvrat[$value->id] += McReturnHistory::where('order_id',$order->id)
                                                            ->whereDate('created_at','>=',$report->active_month)
                                                            ->whereDate('created_at','<=',$report->last_active_month)
                                                            ->sum('amount');
                                }
                            }

                        }
                    }


                }

            #shu_oy_vozvrat

            #yangi_kelgan_pul

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','>=',$report->active_month)
            ->whereDate('order_date','<=',$report->last_active_month)
            ->get();

            $yan_kel_1[$value->id] = 0;
            $yan_kel_2[$value->id] = 0;

            $this->yangi_kelgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    $first_del = McOrderDelivery::where('order_id',$order->id)->orderBy('id','ASC')->first();

                    // $ord = McOrder::where('id',543)->get();
                    // $first_del = McOrderDelivery::where('order_id',$ord[0]->id)->orderBy('id','ASC')->first();

                    if($first_del)
                    {
                        if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                        {
                            $yan_kel_1[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');

                            // $yan_kel_1[$value->id][$order->id] = McPaymentHistory::where('order_id',$order->id)
                            //                             ->whereDate('created_at','>=',$report->active_month)
                            //                             ->whereDate('created_at','<=',$report->last_active_month)
                            //                             ->sum('amount');
                            // dd(McPaymentHistory::where('order_id',$ord[0]->id)
                            // ->whereDate('created_at','>=',$report->active_month)
                            // ->whereDate('created_at','<=',$report->last_active_month)
                            // ->sum('amount'));

                        }
                    }else{
                        $yan_kel_1[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');
                    }

                }
            #yangi_kelgan_pul

            #eski_kelgan_pul
            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','<',$report->active_month)
            ->get();

            $this->eski_kelgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {



                    if($order->prepayment == 1){
                        $this->eski_kelgan_pul[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                    }else{
                        $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                        if($first_del)
                        {
                            if(strtotime($report->active_month) > strtotime($first_del->created_at))
                            {
                                $this->eski_kelgan_pul[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                            } 
                        
                        }
                        
                    }



                }
            #eski_kelgan_pul

            #yangi_qolgan_pul

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','>=',$report->active_month)
            ->whereDate('order_date','<=',$report->last_active_month)
            ->get();
            // $order_price[$value->id] = 0;
            // $ord1[$value->id] = 0;
            // $voz1[$value->id] = 0;
            $this->yangi_qolgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {

                    $first_del = McOrderDelivery::where('order_id',$order->id)->orderBy('id','ASC')->first();

                    if($first_del)
                    {

                    if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                    {

                        $price = McOrderDelivery::where('order_id', $order->id)
                            // ->whereDate('created_at','>=',$report->active_month)
                            // ->whereDate('created_at','<=',$report->last_active_month)
                            ->sum(DB::raw('quantity*price'));

                        $order_price = $price - $price*$order->discount/100;

                        $ord1 = McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');

                        $voz1 = McReturnHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');

                        // $this->yangi_qolgan_pul[$value->id] += $order_price[$value->id];
                        // $testar[$order->id] = $price - $price*$order->discount/100;
                        $this->yangi_qolgan_pul[$value->id] += $order_price - $ord1 -$voz1;
                        // $this->yangi_qolgan_pul[$value->id][$order->id] = $order_price;

                    }
                }

                    // $this->yangi_qolgan_pul[$value->id][$order->id] = $first_del;


                }

            #yangi_qolgan_pul

            #eski_qolgan_pul
            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','<',$report->active_month)
            ->get();

            
            $eski_q_p2[$value->id] = 0;
            $eski_q_p3[$value->id] = 0;

            $this->eski_qolgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {

                    $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                    if($first_del){

                        $price = McOrderDelivery::where('order_id', $order->id)
                         ->whereDate('created_at','<=',$report->last_active_month)
                        ->sum(DB::raw('quantity*price'));

                        $order_last_price = $price - $price*$order->discount/100;

                        $ord_last = McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');
                        $shu_oy = 0;
                        if($order->prepayment == 3){
                            $shu_oy = McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');

                            $ord_last = $ord_last - McPaymentHistory::where('order_id',$order->id)->first()->amount??0;
                            
                            $order_last_price = 0;
                            
                            if(strtotime($report->active_month) > strtotime($first_del->created_at))
                            {
                                $order_last_price = $ord_last;
                            }

                        }

                        $ord_last_vozvrat = McReturnHistory::where('order_id',$order->id)
                                            ->whereDate('created_at','<=',$report->last_active_month)
                                            ->sum('amount');

                        $this->eski_qolgan_pul[$value->id] += $order_last_price - $ord_last - $ord_last_vozvrat + $shu_oy;
                        $testar[$value->id][$order->id] = $order_last_price.'-'.$ord_last.'-'.$ord_last_vozvrat.'-'.$shu_oy;

                    }else{

                        $first_money = McPaymentHistory::where('order_id',$order->id)->first();

                        if( $first_money ){

                            if($order->prepayment == 3)
                            {

                            }

                            $a1 = $order->price;
                            $a2 = McReturnHistory::where('order_id',$order->id)
                                            ->sum('amount');
                            $a3  = McPaymentHistory::where('order_id',$order->id)
                            ->whereDate('created_at','<=',$report->last_active_month)
                            ->sum('amount');

                            if($order->prepayment == 3)
                            {
                                $a3 = 0;
                            }

                            $this->eski_qolgan_pul[$value->id] += $a1 - $a2 - $a3;
                        }else{

                            $order_last_price = $order->price;
                            $ord_last_vozvrat = McReturnHistory::where('order_id',$order->id)
                                            ->sum('amount');
                            $ff = McPaymentHistory::where('order_id',$order->id)
                            ->whereDate('created_at','<=',$report->last_active_month)
                            ->sum('amount');
                            $this->eski_qolgan_pul[$value->id] += $order_last_price - $ord_last_vozvrat;
                        }


                    }



                }

            #eski_qolgan_pul

            #predoplata_otgan_oydan

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->where('prepayment','=',3)
            ->get();

            $this->otgan_oy_predoplata[$value->id] = 0;
            $this->shu_oy_predoplata[$value->id] = 0;

            foreach ($orders as $ord => $order) {

                $first_del = McOrderDelivery::where('order_id',$order->id)->orderBy('id','ASC')->first();
                $first_pay = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first();

                $report_last_active_month = $report->last_active_month.' 23:59:59';

                if(isset($first_del))
                {

                    if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report_last_active_month) >= strtotime($first_del->created_at))
                    {

                        if(isset($first_pay))
                        {
                            $this->otgan_oy_predoplata[$value->id] += $first_pay->amount;

                            $yan_kel_2[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report_last_active_month)
                                                        ->sum('amount');

                            $price = McOrderDelivery::where('order_id', $order->id)
                                                        //  ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report_last_active_month)
                                                        ->sum(DB::raw('quantity*price'));

                            $order_last_price = $price - $price*$order->discount/100;

                            $pay = McPaymentHistory::where('order_id',$order->id)->orderBy('id','ASC')->first()->amount??0;

                            $shu_oy = McPaymentHistory::where('order_id',$order->id)
                            ->whereDate('created_at','>=',$report->active_month)
                            ->whereDate('created_at','<=',$report_last_active_month)
                            ->sum('amount');

                            $a3  = McReturnHistory::where('order_id',$order->id)
                                ->whereDate('created_at','<=',$report_last_active_month)
                                ->sum('amount');
                            $this->yangi_qolgan_pul[$value->id] += $order_last_price - $pay - $a3 - $shu_oy;

                            // $testar[$value->id][$order->id] = $order_last_price.'-'.$pay.'-'.$a3.'-'.$shu_oy;


                        }
                    }

                }else{
                    if(isset($first_pay))
                        {

                            $this->shu_oy_predoplata[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report_last_active_month)
                                                        ->sum('amount');
                        }
                }

                if(isset($first_del))
                {

                    if(strtotime($report_last_active_month) <= strtotime($first_del->created_at))
                    {

                        if(isset($first_pay))
                        {
                            // $this->otgan_oy_predoplata[$value->id] += $first_pay->amount;

                            $yan_kel_2[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report_last_active_month)
                                                        ->sum('amount');

                            $this->shu_oy_predoplata[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report_last_active_month)
                                                        ->sum('amount');

                            // $testar[$value->id][$order->id] = McPaymentHistory::where('order_id',$order->id)
                            //                             ->whereDate('created_at','>=',$report->active_month)
                            //                             ->whereDate('created_at','<=',$report_last_active_month)
                            //                             ->sum('amount');
                        }
                    }
                }

            }
 
            #predoplata_otgan_oydan

            $this->yangi_kelgan_pul[$value->id] = $yan_kel_1[$value->id] + $yan_kel_2[$value->id];



        }

        // dd($testar);

           




    }

    public function hisobotMonth1($regions,$active_month)
    {


        $report = new McReportService($active_month);

        foreach ($regions as $key => $region) {

            // $pharmacy_ids = Pharmacy::where('region_id',9)->pluck('id')->toArray();
            $pharmacy_ids = Pharmacy::where('region_id',$region->id)->pluck('id')->toArray();


            $this->last_close_money = $report->lastCloseMoney($region->id,$pharmacy_ids);
            $this->last_accept_money = $report->lastAcceptMoney($region->id,$pharmacy_ids);

            $this->new_close_money = $report->newCloseMoney($region->id,$pharmacy_ids);
            $this->new_accept_money = $report->newAcceptMoney($region->id,$pharmacy_ids);

            $this->predoplata = $report->predoplata($region->id,$pharmacy_ids);

            $this->predoplata_new = $report->predoplataNew($region->id,$pharmacy_ids);

            // $this->ofis_tovar_qarz = $report->ofisTovarQarz($region->id,$pharmacy_ids);


            $this->all_money[$region->id] = $this->last_close_money[$region->id] + $this->new_close_money[$region->id];

            $otr = $this->new_close_money[$region->id] + $this->new_accept_money[$region->id] + $this->predoplata[$region->id];

            if($otr < $this->predoplata_new[$region->id])
            {
                $this->otgruzka[$region->id] = $this->predoplata_new[$region->id];

            }else{
                $this->otgruzka[$region->id] = $this->new_close_money[$region->id] + $this->new_accept_money[$region->id] + $this->predoplata[$region->id]-$this->predoplata_new[$region->id];

            }

            // $this->otgruzka[$region->id] = $this->new_close_money[$region->id] + $this->new_accept_money[$region->id] + $this->predoplata[$region->id]-$this->predoplata_new[$region->id];

            $this->product_accept[$region->id] = 0;

        }

        // dd($this->predoplata_new[3]);


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
        return view('livewire.mc-report-region');
    }
}
