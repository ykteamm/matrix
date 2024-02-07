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

    public $pharmacy;

    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {
        $this->regions = Region::all();
        $this->months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');

        $this->active_month = date('2023-10-01');


        $this->hisobotMonth($this->active_region_id,$this->active_month);

    }


    public function changeMonth($month)
    {
        $this->active_month = date('Y-m'.'-01',strtotime('01.'.$month));


        // $this->hisobotMonth($this->active_region_id,$this->active_month);



    }

    public function changeRegion($idOrAll)
    {

        $this->active_region = Region::find($idOrAll)->name;
        $this->active_region_id = $idOrAll;



        // $this->hisobotMonth($this->region_id,$this->active_month);


    }

    public function hisobotMonth($region_id,$active_month)
    {

        $region_id = [13];
        $report = new McReportService($active_month);

        $this->pharmacy = Pharmacy::whereIn('region_id',$region_id)->get();
        // dd($this->pharmacy);
        $testar = [];
        $order_price = [];
        $order_last_price = [];
        $ord_last = [];
        $ord_last_vozvrat = [];
        $ff = [];
        foreach ($this->pharmacy as $key => $value) {

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)->get();
            $this->vozvrat[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    $this->vozvrat[$value->id] += McReturnHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                }

            #yangi_kelgan_pul

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','>=',$report->active_month)
            ->whereDate('order_date','<=',$report->last_active_month)
            ->get();

            $this->yangi_kelgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                    
                    if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                    {
                    $this->yangi_kelgan_pul[$value->id] += McPaymentHistory::where('order_id',$order->id)
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
                    }

                    
                }
            #eski_kelgan_pul

            #yangi_qolgan_pul

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','>=',$report->active_month)
            ->whereDate('order_date','<=',$report->last_active_month)
            ->get();
            $order_price[$value->id] = 0;
            $this->yangi_qolgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                    
                    $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                    
                    if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                    {

                    $price = McOrderDelivery::where('order_id', $order->id)
                        ->sum(DB::raw('quantity*price'));

                    $order_price[$value->id] += $price - $price*$order->discount/100;
                    
                    $ord = McPaymentHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                    $voz = McReturnHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount');
                    $this->yangi_qolgan_pul[$value->id] = $order_price[$value->id] - $ord -$voz;
                    }

                }

            #yangi_qolgan_pul
            
            #eski_qolgan_pul
            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->whereDate('order_date','<',$report->active_month)
            ->get();

            if(count($orders) > 0)
            {
                $testar[] = $orders[0];
            }
            $ord_last[$value->id] = 0;
            $ord_last_vozvrat[$value->id] = 0;
            $order_last_price[$value->id] = 0;
            $ff[$value->id] = 0;
            $this->eski_qolgan_pul[$value->id] = 0;
                foreach ($orders as $ord => $order) {
                
                    $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                    if($first_del){
                        $price = McOrderDelivery::where('order_id', $order->id)
                        ->sum(DB::raw('quantity*price'));

                        $order_last_price[$value->id] += $price - $price*$order->discount/100;
                        
                        $ord_last[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                        // ->whereDate('created_at','>=',$report->active_month)
                                                        ->whereDate('created_at','<=',$report->last_active_month)
                                                        ->sum('amount');
                        $ord_last_vozvrat[$value->id] += McReturnHistory::where('order_id',$order->id)
                                            // ->whereDate('created_at','>=',$report->active_month)
                                            // ->whereDate('created_at','<=',$report->last_active_month)
                                            ->sum('amount');

                        $this->eski_qolgan_pul[$value->id] = $order_last_price[$value->id] - $ord_last[$value->id] - $ord_last_vozvrat[$value->id];
                        
                    }else{
                        
                        

                        $first_money = McPaymentHistory::where('order_id',$order->id)->first();

                        if( $first_money ){
                        }else{

                            $order_last_price[$value->id] += $order->price;
                            $ord_last_vozvrat[$value->id] += McReturnHistory::where('order_id',$order->id)
                                            // ->whereDate('created_at','>=',$report->active_month)
                                            // ->whereDate('created_at','<=',$report->last_active_month)
                                            ->sum('amount');
                            $ff[$value->id] = McPaymentHistory::where('order_id',$order->id)
                            // ->whereDate('created_at','>=',$report->active_month)
                            ->whereDate('created_at','<=',$report->last_active_month)
                            ->sum('amount');
                            $this->eski_qolgan_pul[$value->id] = $order_last_price[$value->id] - $ord_last[$value->id];


                        }

                        
                    }
                    

                    
                }
            #eski_qolgan_pul

            #predoplata_otgan_oydan

            $orders = McOrder::with('pharmacy')->where('pharmacy_id',$value->id)
            ->where('prepayment','=',3)
            ->get();



            foreach ($orders as $ord => $order) {

                $first_del = McOrderDelivery::where('order_id',$order->id)->first();
                $first_pay = McPaymentHistory::where('order_id',$order->id)->first();

                $this->otgan_oy_predoplata[$value->id] = 0;


                if(strtotime($report->active_month) <= strtotime($first_del->created_at) && strtotime($report->last_active_month) >= strtotime($first_del->created_at))
                {

                    if(isset($first_pay))
                    {
                        $this->otgan_oy_predoplata[$value->id] += $first_pay->amount;

                        $this->yangi_kelgan_pul[$value->id] += McPaymentHistory::where('order_id',$order->id)
                                                    ->whereDate('created_at','>=',$report->active_month)
                                                    ->whereDate('created_at','<=',$report->last_active_month)
                                                    ->sum('amount'); 
                    }
                }
            }

            #predoplata_otgan_oydan
            



        }

        // dd($testar);


        // $this->orders = McOrder::with('pharmacy')->whereIn('pharmacy_id',$pharmacy_ids)->get();



            // $this->last_close_money = $report->lastCloseMoney($region_id,$pharmacy_ids);
            // $this->last_accept_money = $report->lastAcceptMoney($region_id,$pharmacy_ids);

            // $this->new_close_money = $report->newCloseMoney($region_id,$pharmacy_ids);
            // $this->new_accept_money = $report->newAcceptMoney($region_id,$pharmacy_ids);

            // $this->predoplata = $report->predoplata($region_id,$pharmacy_ids);

            // $this->predoplata_new = $report->predoplataNew($region_id,$pharmacy_ids);

            // $this->ofis_tovar_qarz = $report->ofisTovarQarz($region_id,$pharmacy_ids);


            // $this->all_money[$region_id] = $this->last_close_money[$region_id] + $this->new_close_money[$region_id];

            // $otr = $this->new_close_money[$region_id] + $this->new_accept_money[$region_id] + $this->predoplata[$region_id];

            // if($otr < $this->predoplata_new[$region_id])
            // {
            //     $this->otgruzka[$region_id] = $this->predoplata_new[$region_id];

            // }else{
            //     $this->otgruzka[$region_id] = $this->new_close_money[$region_id] + $this->new_accept_money[$region_id] + $this->predoplata[$region_id]-$this->predoplata_new[$region_id];

            // }

            // $this->otgruzka[$region_id] = $this->new_close_money[$region_id] + $this->new_accept_money[$region_id] + $this->predoplata[$region_id]-$this->predoplata_new[$region_id];

            // $this->product_accept[$region_id] = 0;




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
