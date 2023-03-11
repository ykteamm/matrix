<?php

namespace App\Services;

use App\Items\ElchiTimeItems;
use App\Items\KingSoldSearchItems;
use App\Items\TrendRangeItems;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class KingSoldSearchService
{
    public function kingSoldSearch($user_id,$region_id,$date)
    {
        $user_all_id = $this->getUserID($user_id);
        $region_all_id = $this->getRegionId($region_id);
        $dates = $this->day($date);
        

        $king_sold = DB::table('tg_king_sold')
                    ->selectRaw('count(tg_king_sold.id) as count,tg_order.user_id,tg_user.first_name as f,tg_user.last_name as l,tg_region.name as r,liga_king_users.liga_id as lid')
                    ->where('tg_king_sold.admin_check',1)
                    ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                    ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                    ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                    ->join('tg_user','tg_user.id','tg_order.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->whereIn('tg_user.id',$user_all_id)
                    ->whereIn('tg_region.id',$region_all_id)
                    ->leftjoin('liga_king_users','liga_king_users.user_id','tg_user.id')
                    ->orderBy('count','DESC')
                    ->groupBy('tg_order.user_id','f','l','r','lid')
                    ->get();

        $sharq = DB::table('tg_king_sold')
                    ->selectRaw('count(tg_king_sold.id) as count')
                    ->addSelect(DB::raw('DATE(tg_king_sold.created_at) as date'))
                    ->where('tg_king_sold.admin_check',1)
                    ->where('tg_region.side',2)
                    // ->whereDate('tg_king_sold.created_at','>=','2023-02-04')
                    // ->whereDate('tg_king_sold.created_at','<=',date('Y-m-d'))
                    ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                    ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                    ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                    ->join('tg_user','tg_user.id','tg_order.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('date','ASC')
                    ->groupBy('date')
                    ->get();

        $garb = DB::table('tg_king_sold')
                    ->selectRaw('count(tg_king_sold.id) as count')
                    ->addSelect(DB::raw('DATE(tg_king_sold.created_at) as date'))
                    ->where('tg_king_sold.admin_check',1)
                    ->where('tg_region.side',1)
                    // ->whereDate('tg_king_sold.created_at','>=','2023-02-04')
                    // ->whereDate('tg_king_sold.created_at','<=',date('Y-m-d'))
                    ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                    ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                    ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                    ->join('tg_user','tg_user.id','tg_order.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('date','ASC')
                    ->groupBy('date')
                    ->get();


        $all =  array_reduce($king_sold->toArray(), function($sum, $one) {
            return $sum += $one->count;
        });
        $garbbb =  array_reduce($garb->toArray(), function($sum, $one) {
            return $sum += $one->count;
        });
        $sharqq =  array_reduce($sharq->toArray(), function($sum, $one) {
            return $sum += $one->count;
        });
        // dd($all, $garbbb, $sharqq);
        return $king_sold;
    }

    public function getUserId($user_id)
    {
        if($user_id == 'all')
        {
            $user_all_id = User::join('tg_region','tg_region.id','tg_user.region_id')
            ->where('tg_user.admin',FALSE)
            ->whereIn('tg_region.id',$this->getMyRegion())
            ->pluck('tg_user.id')->toArray();
        }else{
            $user_all_id[] = $user_id;
        }
        return $user_all_id;
    }
    public function getRegionId($region_id)
    {
        if($region_id == 'all')
        {
            $region_all_id = Region::whereIn('id',$this->getMyRegion())
            ->pluck('id')->toArray();
        }else{
            $region_all_id[] = $region_id;
        }
        return $region_all_id;
    }
    public function getMyRegion()
    {
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $r_id_array = Region::pluck('id')->toArray();
            }
            else{
                $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
            }
            return $r_id_array;
    }
    public function day($time)
    {
        
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date_now()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date_now()) ) ));
            $dateText = 'Bugun';
            $dateTexte = 'today';
        }
        elseif ($time == 'week') {
            $date_begin = date_now()->startOfWeek()->format('Y-m-d');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( $date_end) ) ));
            $dateText = 'Hafta';
            $dateTexte = 'week';

        }
        elseif ($time == 'month') {
            $date_begin = date_now()->startOfMonth()->format('Y-m-d');

            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_end) ) ));
            $dateText = 'Oy';
            $dateTexte = 'month';

        }
        elseif ($time == 'year') {
            $date_begin = date_now()->startOfYear()->format('Y-m-d');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_end) ) ));
            $dateText = 'Yil';
            $dateTexte = 'year';

        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date_now()->format('1790-01-01');
            $f_date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
            $dateTexte = 'all';

        }
        else{
            $date_begins = substr($time,0,10);
            $date_ends = substr($time,11);

            $date_begin = date('Y-m-d',strtotime($date_begins));
            $date_end = date('Y-m-d',strtotime($date_ends));

            $farq = intval(date('d',strtotime($date_ends)))-intval(date('d',strtotime($date_begins)))+1;

            $f_date_begin = date('Y-m-d',(strtotime ( '-'.$farq.' day' , strtotime ( substr($time,0,10)) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-'.$farq.' day' , strtotime ( substr($time,11)) ) ));

            $dateText = date('d.m.Y',(strtotime ( $date_begins ) )).'-'.date('d.m.Y',(strtotime ( $date_ends ) ));
            $dateTexte = date('d.m.Y',(strtotime ( $date_begins ) )).'-'.date('d.m.Y',(strtotime ( $date_ends ) ));


        }
        $item=new KingSoldSearchItems();
        $item->date_begin=$date_begin;
        $item->date_end=$date_end;
        $item->dateText=$dateText;
        $item->dateTexte=$dateTexte;
        return $item;
    }
    
}
