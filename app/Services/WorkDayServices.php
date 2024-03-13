<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\DailyWork;
use App\Models\Detail;
use App\Models\PremyaTask;
use App\Models\ProductSold;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkDayServices
{
    public $start_work;
    public $end_work;
    public $user_id;
    public $active;
    public function __construct($id,$act)
    {
        $work = DailyWork::where('user_id',$id)->first();

            if($work == null)
            {
                $new = new DailyWork([
                    'user_id' => $id,
                    'start_work' => '09:00:00',
                    'finish_work' => '18:00:00',
                    'start' => '2023-03-15',
                    'finish' => null,
                    'active' => 1
                ]);
                $new->save();
            }
            $work = DailyWork::where('user_id',$id)->first();

        $this->start_work = $work->start_work;
        $this->end_work = $work->finish_work;
        $this->user_id = $id;

        $this->active = $act;

    }

    public function getReport()
    {
        $month = date('Y-m');
        $start_month = $this->getFirstDate($month.'-01');
        $end_month = $this->getLastDate($month.'-01');

            $arrayDate = array();
            $Variable1 = strtotime($start_month);
            $Variable2 = strtotime($end_month);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400))
            {

                if($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15'))
                {
                    $date = date('Y-m-d', $currentDate);
                    $jarima = $this->getDayJarima($date);
                    $arrayDate[] = $jarima;
                }
            }

        dd($arrayDate);

    }
    public function getReportAllSum($month)
    {

        $start_month = $this->getFirstDate($month);
        $end_month = $this->getLastDate($month);

            $arrayDate = array();
            $Variable1 = strtotime($start_month);
            $Variable2 = strtotime($end_month);
            $sum = 0;
            $sum2 = [];

            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400))
            {
                if($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15'))
                {
                    $date = date('Y-m-d', $currentDate);
                    // $jarima = $this->getDayJarima('2023-03-22');
                    $jarima = $this->getDayJarima($date);
                    if($jarima != 123123)
                    {
                        $sum += $jarima;
                    }
                    $sum2[] = array('jarima' => $jarima,'date' => $date);

                }
            }
            // dd($sum2);

        return $sum;

    }
    public function getReportAllTime($month)
    {
        $start_month = $this->getFirstDate($month);
        $end_month = $this->getLastDate($month);

            $arrayDate = array();
            $Variable1 = strtotime($start_month);
            $Variable2 = strtotime($end_month);
            $sum = 0;
            $sum2 = [];
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400))
            {
                if($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15'))
                {
                    $date = date('Y-m-d', $currentDate);
                    $minut = $this->getMinutesDate($date,$this->user_id);
                    if($minut != 123123)
                    {
                        $sum += $minut;
                    }
                    $sum2[] = array('time' => $minut,'date' => $date);
                }
            }

        return $sum;

    }
    public function getDayJarima($date)
    {
        $minut = $this->getMinutesDate($date,$this->user_id);

        if($minut == 123123)
        {
            return $minut;
        }
        $shift = Shift::whereDate('created_at',$date)->where('user_id',$this->user_id)->where('pharma_id','!=',42)->first();

        $def = 0;

        if($shift == null)
        {
            $def = 1;
        }

        $sum = $this->getOneMinutSum($this->user_id,date('Y-m',strtotime($date)),$date,$def);
        $maosh = $this->getTaqqoslash($sum);
        $jar = $this->getOneMinutJarima($date,$maosh);

        $one_day_minut = $this->getDayMinutes($date,$this->user_id);

        $j = floor($jar*$minut/$one_day_minut);

        // dd($maosh);
        return $j;
    }
    public function getDayMinutes($date,$user_id)
    {
        $th_start_work = $this->getSpecialStartDay($date,$user_id);
        $th_end_work = $this->getSpecialFinishDay($date,$user_id);

        $all_diff = (strtotime($th_end_work) - strtotime($th_start_work))/60;

        if($all_diff/60 > 4)
        {
            $all_diff = $all_diff - 60;
        }

        return $all_diff/60;
    }
    public function getMinutesDate($date,$user_id)
    {


        // $date = '2024-01-20';

        // dd($date);
        $day = $this->getWorkInMonth(date('m.Y',strtotime($date)));



        $day_json = json_decode($day->day_json);

        $add_array = json_decode($day->add_day);

        $day_s = date('d', (strtotime($date)));


        $ddd = $day_json[$day_s-1];

        $if_user = DB::table('teacher_users')->where('user_id',$user_id)->first();


        if($if_user)
        {
            if(strtotime($date) < strtotime($if_user->week_date))
                {
                    return 0;
                }
        }


        $if_user_work = DB::table('tg_user')->where('id',$user_id)->first();

        if($if_user_work)
        {
            if($if_user_work->work_start != null)
            {
                if(strtotime($date) < strtotime($if_user_work->work_start))
                {
                    return 0;
                }
            }else{
                if(strtotime($date) < strtotime($if_user_work->date_joined))
                {
                    return 0;
                }
            }

            if($if_user_work->work_end != null)
            {
                if(strtotime($date) >= strtotime($if_user_work->work_end))
                {
                    return 0;
                }
            }
        }

        if($date < '2023-03-15' || $ddd == 'false' || in_array($day_s,$add_array))
        {
            return 0;
        }

        $th_start_work = $this->getSpecialStartDay($date,$user_id);
        $th_end_work = $this->getSpecialFinishDay($date,$user_id);

        $shift = Shift::whereDate('created_at',$date)->where('user_id',$user_id)->where('pharma_id','!=',42)->first();

        if($shift == NULL)
        {
            if($this->active == 1)
            {
                $all_diff = (strtotime($th_end_work) - strtotime($th_start_work))/60;

                if($all_diff/60 > 4)
                {
                    $all_diff = $all_diff - 60;
                }
            }else{
                $all_diff = 123123;
            }

        }else{

            if($shift->close_date == null)
            {
                $table = ProductSold::where('user_id',$shift->user_id)->whereDate('created_at',$shift->created_at)->orderByDesc('id')->value('created_at');
                if($table == null)
                {
                    $close_date = date('H:i:s',strtotime ( $shift->open_date ));

                }else{
                    $close_date = date('H:i:s',strtotime ( $table ));
                }
            }else{
                $close_date = date('H:i:s',strtotime($shift->close_date));
            }


            $open_date = date('H:i:s',strtotime($shift->open_date));


            $all_diff_g = (strtotime($close_date) - strtotime($open_date))/60;



            if($all_diff_g/60 > 4)
            {
                $all_diff_g = $all_diff_g - 60;
            }


            if(strtotime($open_date) > strtotime($th_start_work))
            {
                $diff_open = (strtotime($open_date) - strtotime($th_start_work))/60;

                if($diff_open <= 10)
                {
                    $diff_open = 0;
                }
            }else{
                $diff_open = 0;
            }

            if(strtotime($close_date) < strtotime($th_end_work))
            {
                if(date('w',strtotime($date)) == 6)
                {
                    $diff_close = (strtotime($th_end_work) - strtotime($close_date))/60;


                    if($diff_close <= 120)
                    {
                        $diff_close = 0;
                    }else{
                        $diff_close = $diff_close - 120;
                    }
                }else{
                    $diff_close = (strtotime($th_end_work) - strtotime($close_date))/60;
                    if($diff_close <= 10)
                    {
                        $diff_close = 0;
                    }
                }

            }else{
                $diff_close = 0;
            }
                $all_diff = $diff_open + $diff_close;
        }
        return $all_diff;
    }
    public function getSpecialStartDay($date,$user_id)
    {
        // dd($date);
        $work = DailyWork::where('user_id',$user_id)
        ->whereDate('start','<=',$date)
        ->orderBy('id','DESC')
        ->first();
        if($work == null)
        {
            $date = '09:00:00';
        }else{
            $date = $work->start_work;
        }
        return $date;
    }
    public function getSpecialFinishDay($date,$user_id)
    {
        $work = DailyWork::where('user_id',$user_id)
        ->whereDate('start','<=',$date)
        ->orderBy('id','DESC')
        ->first();
        if($work == null)
        {
            $date = '18:00:00';
        }else{
            $date = $work->finish_work;
        }
        return $date;
    }
    public function getOneMinutSum($user_id,$month,$date,$def)
    {
        $start_month = $this->getFirstDate($month.'-01');
        $end_month = $this->getLastDate($month.'-01');
        if($def == 1)
        {
            $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->whereDate('tg_productssold.created_at','>=',$start_month)
            ->whereDate('tg_productssold.created_at','<=',$end_month)
            ->where('tg_productssold.user_id','=',$user_id)
            ->first()->allprice;
        }else{
            $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->whereDate('tg_productssold.created_at','>=',$month.'-01')
            ->whereDate('tg_productssold.created_at','<=',$date)
            ->where('tg_productssold.user_id','=',$user_id)
            ->first()->allprice;
        }

        if($summa == NULL)
        {
            $summa = 0;
        }
        return $summa;
    }

    public function getTaqqoslash($sum)
    {
        // if($sum < 15000000)
        // {
        //     $compare = 2000000;
        // }elseif($sum >= 15000000 && $sum < 25000000)
        // {
        //     $compare = ($sum*20)/150;
        // }elseif($sum >= 25000000 && $sum < 35000000)
        // {
        //     $compare = ($sum*35)/150;
        // }else{
        //     $compare = ($sum*50)/150;
        // }
        // return $compare;

        if($sum < 25000000)
        {
            $koef = 2000000/15000000;
            $oylik = $sum*$koef;
        }elseif ($sum >= 25000000 && $sum < 35000000) {
            $koef = 3500000/25000000;
            $oylik = $sum*$koef;
        }else{
            $koef = 5000000/35000000;
            $oylik = $sum*$koef;
        }

        return $oylik;
    }

    public function getOneMinutJarima($month,$sum)
    {
        $start_month = $this->getFirstDate($month);
        $end_month = $this->getLastDate($month);

        $start = strtotime($start_month);
        $end = strtotime($end_month);

        $count = 0;
        while(date('Y-m-d', $start) <= date('Y-m-d', $end)){
            $count += date('w', $start) == 0 ? 0 : 1;
            $start = strtotime("+1 day", $start);
        }

        // $work_day = $this->getWorkInMonth($month)->work_day;

        // $add_array = json_decode($this->getWorkInMonth($month)->add_day);

        $all_minuts = $count*60;

        $jar = $sum/$all_minuts;

        // dd($count);

        return $jar;
    }
    // public function getOneDayTime()
    // {
    //     $start_work = strtotime($this->start_work);
    //     $end_work = strtotime($this->end_work);

    //     $interval = ($end_work - $start_work)/3600;

    //     if($interval > 6)
    //     {
    //         $interval = ($end_work - $start_work - 3600);
    //     }else{
    //         $interval = ($end_work - $start_work);
    //     }
    //     return $interval;
    // }

    public function getWorkInMonth($month)
    {
        $cal = Calendar::where('year_month',$month)->first();
        return $cal;
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

    public function getMonthMaosh($month)
    {

            // dd($work_start);
            $date = $month.'-01';

            $date_begin = $this->getFirstDate($date);
            $date_end = $this->getLastDate($date);


            $month_sol = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_productssold.user_id',$this->user_id)
            ->get()[0]->allprice;

            if($month_sol == NULL)
            {
                $month_sol = 0;
            }

            $jarima = $this->getReportAllSum($date);
            $time = $this->getReportAllTime($date);

            $user = User::find($this->user_id);

            $names = $user->last_name.' '.$user->first_name;

            $shtr = getShtrafDefault($date_begin,$date_end,$this->user_id);

            $shtraf = 0;
            if(count($shtr) > 0)
            {
                foreach($shtr as $sh)
                {
                    $shtraf = $shtraf + $sh->price;
                }
            }

            $premya = Detail::where('user_id',$this->user_id)->where('status',1)
            ->whereDate('created_at','>=',$date_begin)
            ->whereDate('created_at','<=',$date_end)
            ->sum('price');

            $specialty_id = User::find($this->user_id);


            $money_premya = PremyaTask::with('premya')->where('user_id',$this->user_id)
            ->whereDate('created_at','>=',$date_begin)
            ->whereDate('created_at','<=',$date_end)
            ->where('active',1)
            ->orderBy('premya_id','ASC')
            ->get();




            $st = array(
                'maosh' =>maosh($month_sol),
                'summa' => $month_sol,
                'jarima' => $jarima,
                'time' => $time,
                'id' => $this->user_id,
                'name' => $names,
                'premya' => $premya,
                'shtraf' => $shtraf,
                'spec' => $specialty_id->specialty_id,
                'money_premya' => $money_premya
            );

            $ws = DB::table('tg_user')->where('id',$this->user_id)->first();

            $work_start = $ws->work_start;

            if(strtotime($date_begin) <= strtotime($work_start) && strtotime($work_start) <= strtotime($date_end))
            {

                $work_day = Shift::where('user_id',$this->user_id)->where('open_date','!=',NULL)
                            ->whereDate('open_date','>=',$work_start)
                            ->whereDate('open_date','<=',$date_end)
                            ->count('id');

                            $day = $this->getWorkInMonth(date('m.Y',strtotime($date)));

                            $add_array = json_decode($day->add_day);

                            $work_day_in = $day->work_day - count($add_array);

                $maosh = floor($work_day * 2000000 / $work_day_in);



                $st = array(
                    'maosh' =>$maosh,
                    'summa' => $month_sol,
                    'jarima' => $jarima,
                    'time' => $time,
                    'id' => $this->user_id,
                    'name' => $names,
                    'premya' => $premya,
                    'shtraf' => $shtraf,
                    'spec' => $specialty_id->specialty_id,
                    'money_premya' => $money_premya
                );
            }

            $plus_date = date('Y-m-d',(strtotime ( '30 days' , strtotime ( $work_start ) ) ));


            if(strtotime($date_begin) <= strtotime($plus_date) && strtotime($plus_date) <= strtotime($date_end))
            {
                $last_plus_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin ) ) ));

                // $ldate_begin = $this->getFirstDate($last_plus_date);
                // $ldate_end = $this->getLastDate($last_plus_date);

                $work_day = Shift::where('user_id',$this->user_id)->where('open_date','!=',NULL)
                            ->whereDate('open_date','>=',$date_begin)
                            ->whereDate('open_date','<',$plus_date)
                            ->count('id');


                            $day = $this->getWorkInMonth(date('m.Y',strtotime($date_begin)));

                            $add_array = json_decode($day->add_day);

                            $work_day_in = $day->work_day - count($add_array);

                $maosh = floor($work_day * 2000000 / $work_day_in);

                $month_sol = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.user_id',$this->user_id)
                ->get()[0]->allprice;

                if($month_sol == NULL)
                {
                    $month_sol = 0;
                }

                $oylik = floor(maosh($month_sol) + $maosh);


                $st = array(
                    'maosh' =>$oylik,
                    'summa' => $month_sol,
                    'jarima' => $jarima,
                    'time' => $time,
                    'id' => $this->user_id,
                    'name' => $names,
                    'premya' => $premya,
                    'shtraf' => 0,
                    'spec' => $specialty_id->specialty_id,
                    'money_premya' => $money_premya
                );
            }



        return $st;

    }

    public function getMonthMaoshKunlik($month)
    {
        $date = $month.'-01';
            // $date = date('Y-m-d',(strtotime ( '-'.$i.' month' , strtotime ( Carbon::now() ) ) ));
        $date_begin = $this->getFirstDate($date);
        $date_end = $this->getLastDate($date);
        $Variable1 = strtotime($date_begin);
        $Variable2 = strtotime($date_end);
        $arr = [];

        for ($currentDate = $Variable2; $currentDate >= $Variable1;$currentDate -= (86400))
        {
            $hafta = date('w', $currentDate);
            if($hafta == 0)
            {
                $hafta_kuni = 'Yakshanba';
            }elseif($hafta == 1)
            {
                $hafta_kuni = 'Dushanba';
            }elseif($hafta == 2)
            {
                $hafta_kuni = 'Seshanba';
            }elseif($hafta == 3)
            {
                $hafta_kuni = 'Chorshanba';
            }elseif($hafta == 4)
            {
                $hafta_kuni = 'Payshanba';
            }elseif($hafta == 5)
            {
                $hafta_kuni = 'Juma';
            }else
            {
                $hafta_kuni = 'Shanba';
            }
            $day_sol = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                ->whereDate('tg_productssold.created_at',date('Y-m-d', $currentDate))
                ->where('tg_productssold.user_id',$this->user_id)
                ->get()[0]->allprice;
            if($day_sol == NULL)
                {
                    $day_sol = 0;
                }
            if($currentDate >= strtotime('2023-03-15') && $currentDate != strtotime(date('Y-m-d')) && $currentDate < strtotime(date('Y-m-d')))
            {
                $jarima = $this->getDayJarima(date('Y-m-d', $currentDate));
                $minut = $this->getMinutesDate(date('Y-m-d', $currentDate),$this->user_id);
                $shifts = Shift::where('user_id',$this->user_id)->whereDate('open_date','=',date('Y-m-d', $currentDate))->first();

            }else{
                $jarima = 0;
                $minut = 0;
                $shifts = null;
            }

            $shtraf = Detail::where('user_id',$this->user_id)->where('status',2)
            ->whereDate('created_at','=',date('Y-m-d', $currentDate))
            ->first();

            $premya = Detail::where('user_id',$this->user_id)->where('status',1)
            ->whereDate('created_at','=',date('Y-m-d', $currentDate))
            ->first();


            $arr[date('Y-m-d', $currentDate)] = array('id' => $this->user_id,
            'maosh' => maosh($day_sol),
            'jarima' => $jarima,
            'minut' => $minut,
            'shift' => $shifts,
            'shtraf' => $shtraf,
            'premya' => $premya,
            'hafta_kuni' => $hafta_kuni,
        );

        }

        return $arr;
        // dd($arr);
    }


}
