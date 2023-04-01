<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\DailyWork;
use App\Models\Shift;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkDayServices
{
    public $start_work;
    public $end_work;
    public $id;
    public function __construct($id)
    {
        $work = DailyWork::where('user_id', $id)->first();
        $this->id = $id;
        $this->start_work = $work->start_work ?? "09:00";
        $this->end_work = $work->finish_work ?? "18:00";
    }

    public function fff($month)
    {
        $monthStartDate = $month ? $this->sMonth($month) : Carbon::now()->startOfMonth()->format('Y-m-d');
        $endday = $month ? $this->eMonth($month) : date('Y-m-d', (strtotime(Carbon::now())));
        // dd($monthStartDate, $endday);
        $Variable1 = strtotime($monthStartDate);
        $Variable2 = strtotime($endday);
        $arr = [];
        $arr2 = [];
        $arr3 = [];
        for ($currentDate = $Variable2; $currentDate >= $Variable1; $currentDate -= (86400)) {

            $day_sol = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
                ->whereDate('tg_productssold.created_at', date('Y-m-d', $currentDate))
                ->where('tg_productssold.user_id', $this->id)
                ->get()[0]->allprice;
            if ($day_sol == NULL) {
                $day_sol = 0;
            }
            // $service = new WorkDayServices;
            // $arr2[date('Y-m-d', $currentDate)] = array('maosh' => maosh($day_sol));
            if ($currentDate >= strtotime('2023-03-15') && $currentDate != strtotime(date('Y-m-d'))) {
                $jarima = $this->getDayJarima(date('Y-m-d', $currentDate));
            } else {
                $jarima = 0;
            }
            $arr2[date('Y-m-d', $currentDate)] = array('maosh' => $this->maosh($day_sol), 'jarima' => $jarima, 'minut' => $this->getMinutesDate(date('Y-m-d', $currentDate), $this->id));
        }
        return $arr2;
    }

    public function sMonth($month)
    {
        return Carbon::parse($month)->startOfMonth()->format("Y-m-d");
    }

    public function eMonth($month)
    {
        return Carbon::parse($month)->endOfMonth()->format("Y-m-d");
    }

    public function maosh($sum)
    {
        if ($sum < 25000000) {
            $koef = 2000000 / 15000000;
            $oylik = $sum * $koef;
        } elseif ($sum >= 25000000 && $sum < 35000000) {
            $koef = 3500000 / 25000000;
            $oylik = $sum * $koef;
        } else {
            $koef = 5000000 / 35000000;
            $oylik = $sum * $koef;
        }

        return $oylik;
    }

    public function getReport()
    {
        $month = date('Y-m');
        $start_month = $this->getFirstDate($month . '-01');
        $end_month = $this->getLastDate($month . '-01');

        $arrayDate = array();
        $Variable1 = strtotime($start_month);
        $Variable2 = strtotime($end_month);
        $sum = 0;
        for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {

            if ($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15')) {
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

        for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
            if ($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15')) {
                $date = date('Y-m-d', $currentDate);
                $jarima = $this->getDayJarima($date);
                $sum += $jarima;
                $sum2[] = array('jarima' => $jarima, 'date' => $date);
            }
        }

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
        for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
            if ($currentDate < strtotime(date('Y-m-d')) && $currentDate >= strtotime('2023-03-15')) {
                $date = date('Y-m-d', $currentDate);
                $minut = $this->getMinutesDate($date, $this->id);
                $sum += $minut;
                $sum2[] = array('time' => $minut, 'date' => $date);
            }
        }

        return $sum;
    }
    public function getDayJarima($date)
    {
        $sum = $this->getOneMinutSum($this->id, date('Y-m'), $date);
        $maosh = $this->getTaqqoslash($sum);
        $jar = $this->getOneMinutJarima(date('m.Y'), $maosh);
        $minut = $this->getMinutesDate($date, $this->id);

        return floor($jar * $minut);
    }
    public function getMinutesDate($date, $user_id)
    {

        // dd($date);
        $day = $this->getWorkInMonth(date('m.Y',strtotime($date)));

        $day_json = json_decode($day->day_json);

        $add_array = json_decode($day->add_day);

        $day_s = date('d', (strtotime($date)));
        $ddd = $day_json[$day_s - 1];

        if ($date < '2023-03-15' || $ddd == 'false' || in_array($day_s, $add_array)) {
            return 0;
        }
        $shift = Shift::whereDate('created_at', $date)->where('user_id', $user_id)->first();

        if ($shift == NULL) {
            $all_diff = 0;
        } else {

            $open_date = date('H:i:s', strtotime($shift->open_date));
            $close_date = date('H:i:s', strtotime($shift->close_date));

            $th_start_work = $this->getSpecialStartDay($date, $user_id);
            $th_end_work = $this->getSpecialFinishDay($date, $user_id);


            if (strtotime($open_date) > strtotime($th_start_work)) {
                $diff_open = (strtotime($open_date) - strtotime($th_start_work)) / 60;
                if ($diff_open <= 10) {
                    $diff_open = 0;
                }
            } else {
                $diff_open = 0;
            }

            if (strtotime($close_date) < strtotime($th_end_work)) {
                $diff_close = (strtotime($th_end_work) - strtotime($close_date)) / 60;
                if ($diff_close <= 10) {
                    $diff_close = 0;
                }
            } else {
                $diff_close = 0;
            }

            $all_diff = $diff_open + $diff_close;
        }

        return $all_diff;
    }
    public function getSpecialStartDay($date, $user_id)
    {
        $work = DailyWork::where('user_id', $user_id)
            ->whereDate('start', '<=', $date)
            ->orderBy('id', 'DESC')
            ->first();
        return $work->start_work;
    }
    public function getSpecialFinishDay($date, $user_id)
    {
        $work = DailyWork::where('user_id', $user_id)
            ->whereDate('start', '<=', $date)
            ->orderBy('id', 'DESC')
            ->first();
        return $work->finish_work;
    }
    public function getOneMinutSum($user_id, $month, $date)
    {
        $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->whereDate('tg_productssold.created_at', '>=', $month . '-01')
            ->whereDate('tg_productssold.created_at', '<=', $date)
            ->where('tg_productssold.user_id', '=', $user_id)
            ->first()->allprice;
        if ($summa == NULL) {
            $summa = 0;
        }
        return $summa;
    }

    public function getTaqqoslash($sum)
    {
        if ($sum < 15000000) {
            $compare = 2000000;
        } elseif ($sum >= 15000000 && $sum < 25000000) {
            $compare = ($sum * 20) / 150;
        } elseif ($sum >= 25000000 && $sum < 35000000) {
            $compare = ($sum * 35) / 150;
        } else {
            $compare = ($sum * 50) / 150;
        }
        return $compare;
    }

    public function getOneMinutJarima($month, $sum)
    {
        $work_day = $this->getWorkInMonth($month)->work_day;

        $all_minuts = $work_day * 24 * 60;

        $jar = $sum / $all_minuts;

        return $jar;
    }
    public function getOneDayTime()
    {
        $start_work = strtotime($this->start_work);
        $end_work = strtotime($this->end_work);

        $interval = ($end_work - $start_work) / 3600;

        if ($interval > 6) {
            $interval = ($end_work - $start_work - 3600);
        } else {
            $interval = ($end_work - $start_work);
        }
        return $interval;
    }

    public function getWorkInMonth($month)
    {
        $cal = Calendar::where('year_month', $month)->first();
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
}
