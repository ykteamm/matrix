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
        // $user_all_id = $this->getUserID($user_id);
        $dates = $this->day($date);
        $region_all_id = $this->getRegionId($region_id);

        if($user_id == 'all')
        {
            $king_array = $this->kingSoldSearchUserAll($region_id,$date);
        }else{
            $king_array = [];
            $king_sold = DB::table('tg_king_sold')
                        ->selectRaw('count(tg_king_sold.id) as count')
                        ->where('tg_king_sold.admin_check',1)
                        ->where('tg_king_sold.status',1)
                        ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                        ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                        ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                        ->join('tg_user','tg_user.id','tg_order.user_id')
                        ->join('tg_region','tg_region.id','tg_user.region_id')
                        ->where('tg_user.id',$user_id)
                        // ->whereIn('tg_region.id',$region_all_id)
                        ->leftjoin('liga_king_users','liga_king_users.user_id','tg_user.id')
                        ->get();
                        if($king_sold[0]->count == null)
                        {
                            $count = 0;
                        }else{
                            $count = $king_sold[0]->count;
                        }
                        
                        $king_sold05 = DB::table('tg_king_sold')
                        ->selectRaw('count(tg_king_sold.id) as count')
                        ->where('tg_king_sold.admin_check',1)
                        ->where('tg_king_sold.status',2)
                        ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                        ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                        ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                        ->join('tg_user','tg_user.id','tg_order.user_id')
                        ->join('tg_region','tg_region.id','tg_user.region_id')
                        ->where('tg_user.id',$user_id)
                        // ->whereIn('tg_region.id',$region_all_id)
                        ->leftjoin('liga_king_users','liga_king_users.user_id','tg_user.id')
                        ->get();
                        if($king_sold05[0]->count == null)
                        {
                            $count05 = 0;
                        }else{
                            $count05 = $king_sold05[0]->count;
                        }
                        $all_count = $count + $count05/2;
                        if($all_count != 0)
                        {
                            $user = User::find($user_id);
                            $liga_id = DB::table('liga_king_users')->where('user_id',$user_id)->first();
                            $region = Region::find($user->region_id);
                            $king_array[] = array('user_id' => $user->id,'lid' => $liga_id->liga_id,'f' => $user->first_name,'l' => $user->last_name,'count' => $all_count,'r' => $region->name);
                        }
        }
        return $king_array;
    }
    public function kingSoldSearchUserAll($region_id,$date)
    {
        $region_all_id = $this->getRegionId($region_id);
        $dates = $this->day($date);
            $liga_user_id = DB::table('liga_king_users')->get();
                    $king_array=[];
                    foreach ($liga_user_id as $key => $value) {
                        $king_sold = DB::table('tg_king_sold')
                        ->selectRaw('count(tg_king_sold.id) as count')
                        ->where('tg_king_sold.admin_check',1)
                        ->where('tg_king_sold.status',1)
                        ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                        ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                        ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                        ->join('tg_user','tg_user.id','tg_order.user_id')
                        ->join('tg_region','tg_region.id','tg_user.region_id')
                        ->where('tg_user.id',$value->user_id)
                        // ->whereIn('tg_region.id',$region_all_id)
                        ->leftjoin('liga_king_users','liga_king_users.user_id','tg_user.id')
                        ->get();
                        if($king_sold[0]->count == null)
                        {
                            $count = 0;
                        }else{
                            $count = $king_sold[0]->count;
                        }

                        
                        $king_sold05 = DB::table('tg_king_sold')
                        ->selectRaw('count(tg_king_sold.id) as count')
                        ->where('tg_king_sold.admin_check',1)
                        ->where('tg_king_sold.status',2)
                        ->whereDate('tg_king_sold.created_at','>=',$dates->date_begin)
                        ->whereDate('tg_king_sold.created_at','<=',$dates->date_end)
                        ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                        ->join('tg_user','tg_user.id','tg_order.user_id')
                        ->join('tg_region','tg_region.id','tg_user.region_id')
                        ->where('tg_user.id',$value->user_id)
                        // ->whereIn('tg_region.id',$region_all_id)
                        ->leftjoin('liga_king_users','liga_king_users.user_id','tg_user.id')
                        ->get();
                        if($king_sold05[0]->count == null)
                        {
                            $count05 = 0;
                        }else{
                            $count05 = $king_sold05[0]->count;
                        }
                        $all_count = $count + $count05/2;
                        if($all_count != 0)
                        {
                            $user = User::find($value->user_id);
                            $region = Region::find($user->region_id);
                            $king_array[] = array('user_id' => $user->id,'lid' => $value->liga_id,'f' => $user->first_name,'l' => $user->last_name,'count' => $all_count,'r' => $region->name);
                        }
                    
                    }
                    array_multisort(array_column($king_array, 'count'),SORT_DESC, $king_array);
                    
                    // dd($)
        
        return $king_array;
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
