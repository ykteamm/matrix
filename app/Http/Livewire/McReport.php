<?php

namespace App\Http\Livewire;

use App\Models\Calendar;
use App\Models\McOrder;
use App\Models\McOrderDetail;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use App\Models\Pharmacy;
use App\Models\Region;
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
    public $product_accept = [];
    public $all_money = [];



    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_McMonth' => 'changeMonth',
    ];

    public function mount()
    {

        $this->regions_all = Region::all();
        $this->regions = Region::all();
        $this->months = Calendar::where('id','>',24)->orderBy('id','ASC')->pluck('year_month');

        $this->active_month = date('Y-m'.'-01');
        $this->active_region = 'Hammasi';
        
        $this->hisobot($this->regions_all,$this->active_month);
    }

    public function changeRegion($idOrAll)
    {
        if($idOrAll == 'all')
        {
            $this->active_region = 'Hammasi';
            $this->regions = Region::all();

        }else{
            $this->active_region = Region::find($idOrAll)->name;
            $this->regions = Region::where('id',$idOrAll)->get();
        }

        $this->hisobot($this->regions,$this->active_month);

    }

    public function changeMonth($month)
    {
        $this->active_month = date('Y-m'.'-01',strtotime('01.'.$month));
        $this->hisobot($this->regions,$this->active_month);

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
            $sum3 = 0;
            $pred2 = [];
            $pred3 = [];
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
                            $sum3 += $ord_sum->amount;
                        }
                    }
                }


            }

            $pred_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
            ->whereDate('order_date','>=',$active_month)
            ->get();
            $sum4 = 0;
            foreach ($pred_order_ids as $key => $value) {

                if($value->price == NULL)
                {

                    $sum4 += McPaymentHistory::where('order_id',$value->id)->orderBy('id','ASC')
                    ->sum('amount');
                }
            }

            $this->predoplata[$region->id] = $sum1;
            $pred2[$region->id] = $sum2+$sum4;
            $pred3[$region->id] = $sum3;

        //predoplata-end
        
       
            

        //kelganpul-begin
            $all_order_ids = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
            ->whereDate('order_date','<=',$last_active_month)
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
            // $this->last_accept_money[$region->id] = $ords_sum;
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
                            // $e_date = date('Y-m-d',strtotime($ord_sum->created_at));
                            // $f_date = $this->getFirstDate($e_date);
                            // $n_date = $this->getLastDate($e_date);
    
                            // $sum1 += McPaymentHistory::where('order_id',$value)
                            // ->where('id','!=',$ord_sum->id)
                            // ->whereDate('created_at','>=',$f_date)
                            // ->whereDate('created_at','<=',$n_date)
                            // ->sum('amount');

                            $ords = McOrder::find($value);
                            $sum1 += $ords->price - $ords->price*$ords->discount/100;
                        }
                    }else{
                        // $ords = McOrder::find($value);
                        // $sum1 += $ords->price - $ords->price*$ords->discount/100;
                    }
                    
                }else{
                    // $ords = McOrder::find($value);
                    // $sum1 += $ords->price - $ords->price*$ords->discount/100;
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

            // $this->new_accept_money[$region->id] = $this->new_close_money[$region->id];
            // $this->new_accept_money[$region->id] = $sum1;
            $this->new_accept_money[$region->id] = $ords_sum2+$sum1-$this->new_close_money[$region->id]-$this->predoplata[$region->id]+$pred2[$region->id];
            // $this->new_accept_money[$region->id] = $pred2[$region->id];

            if($this->new_accept_money[$region->id] < 0)
            {
                $this->new_accept_money[$region->id] = 0;
            }

            $this->product_accept[$region->id] = McOrderDetail::whereIn('order_id',$new_order_ids)
            ->sum(DB::raw('debt*price'));
        //yangi-qarz-qoldi-end

        }
// dd($this->new_accept_money[13]);

        // $pharmacy_ids = Pharmacy::where('region_id',13)->pluck('id')->toArray();

        // $new_order_ids2 = McOrder::whereIn('pharmacy_id',$pharmacy_ids)
        // ->whereDate('order_date','>=',$last_month)
        // ->whereDate('order_date','<',$active_month)
        // ->pluck('id')->toArray();

        // $sum1 = 0;
        // foreach ($new_order_ids2 as $key => $value) {
        //     $ord_det = McOrderDetail::where('order_id',$value)->orderBy('id','ASC')->first();
        //     $ord_sum = McPaymentHistory::where('order_id',$value)->orderBy('id','ASC')->first();
        //     if($ord_sum)
        //     {
        //         if($ord_det)
        //         {
        //             if(strtotime($ord_det->created_at) > strtotime($ord_sum->created_at))
        //             {
        //                 $e_date = date('Y-m-d',strtotime($ord_sum->created_at));
        //                 $f_date = $this->getFirstDate($e_date);
        //                 $n_date = $this->getLastDate($e_date);

        //                 $sum1 += McPaymentHistory::where('order_id',$value)
        //                 ->where('id','!=',$ord_sum->id)
        //                 ->whereDate('created_at','>=',$f_date)
        //                 ->whereDate('created_at','<=',$n_date)
        //                 ->sum('amount');

        //             }
        //         }else{
        //             $ords = McOrder::find($value);
        //             $sum1 += $ords->price - $ords->price*$ords->discount/100;
        //         }
                
        //     }else{
        //         $ords = McOrder::find($value);
        //         $sum1 += $ords->price - $ords->price*$ords->discount/100;
        //     }
        // }
            // $ords_sum2 = [];
            // foreach ($new_order_ids as $key => $value) {
            //     $ords = McOrder::find($value);
            //     $ords_sum2[$ords->number] = $ords->price - $ords->price*$ords->discount/100;
            // }
// dd($sum1);

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
