<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class NovatioController extends Controller
{
    public function region(Request $request)
    {
        $inputs = $request->all();
        $time = $inputs['time'];
        
        
        if($request->cate == 'med')
        {
            if ($request->medi == 'all') {
                $medi_begin = 1;
                $medi_end = 100000;
            }
            if($request->medi !== 'all'){
                $medi_begin = $request->medi;
                $medi_end = $request->medi;
            }

            $cate_begin = 1;
            $cate_end = 100000;
        }

        if($request->medi == 'cate')
        {
            if ($request->cate == 'all') {
                $cate_begin = 1;
                $cate_end = 100000;
            }
            if($request->cate !== 'all'){
                $cate_begin = $request->cate;
                $cate_end = $request->cate;
            }

            $medi_begin = 1;
            $medi_end = 100000;
        }

        if ($request->user == 'all') {
            $user_begin = 1;
            $user_end = 100000;
        }
        if ($request->user !== 'all') {
            $user_begin = $request->user;
            $user_end = $request->user;
        }
        if ($request->order == 'all') {
            $order_begin = 1;
            $order_end = 100000;
        }
        if ($request->order !== 'all') {
            $order_begin = $request->order;
            $order_end = $request->order;
        }
        if ($request->time == 'a_today') {
            $date_begin = today();
            $date_end = today();
        }
        elseif ($request->time == 'a_week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');
        }
        elseif ($request->time == 'a_month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');
        }
        elseif ($request->time == 'a_year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');
        }
        elseif ($request->time == 'a_all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');
        }
        else{
            $date_begin = $request->time;
            $date_end = $request->time;
        }
        if($inputs['id'] == 'all')
        {
            $region = DB::table('tg_region')->get();
            $all = [];
                $user = DB::table('tg_productssold')
                ->select('tg_order.id as t_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->where('tg_user.id','>=',$user_begin)
                ->where('tg_user.id','<=',$user_end)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_order','tg_order.id','tg_productssold.order_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
        ->orderBy('tg_order.id', 'DESC')

                ->get();
        }else{
        $user = DB::table('tg_productssold')->where('tg_region.id',$inputs['id'])
        ->select('tg_order.id as t_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
        ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->where('tg_user.id','>=',$user_begin)
                ->where('tg_user.id','<=',$user_end)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
        ->join('tg_user','tg_user.id','tg_productssold.user_id')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
        ->join('tg_order','tg_order.id','tg_productssold.order_id')
        ->join('tg_category','tg_category.id','tg_medicine.category_id')

        ->orderBy('tg_order.id', 'DESC')
        ->get();
        }

        
        
        
        return [
            'data' => $user
        ];
    }
    public function regionChart(Request $request)
    {
        if ($request->time == 'a_today') {
            $date_begin = today();
            $date_end = today();

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));

        }
        
        elseif ($request->time == 'a_week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-2 week' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( today()) ) ));
        }
        elseif ($request->time == 'a_month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-m-01');
        }
        elseif ($request->time == 'a_year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-01-01');
        }
        elseif ($request->time == 'a_all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = today()->format('1790-01-01');
            $f_date_end = today()->format('Y-m-d');
        }
        else{
            $date_begin = $request->time;
            $date_end = $request->time;

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $request->time) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $request->time) ) ));
        }
        $regions = DB::table('tg_region')->get();
        $users = DB::table('tg_user')->get();
        $category = DB::table('tg_category')->get();

        $sum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();

        $fsum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();


        $summa = 0;
        $fsumma = 0;
        $u_summa = 0;
        $fu_summa = 0;
        $array = [];
        $userArray = [];
        $regionArray = [];
        $SummaArray = [];
        $usersArray = [];
        $usersummaArray = [];

        $catarray = [];
        $c_summa = 0;
        foreach ($regions as $key => $value) {
            foreach ($sum as $keys => $values) {
                if($value->id == $values->r_id)
                {
                    $summa = $summa + ($values->m_number * $values->price);
                }

            }

            foreach ($fsum as $fkeys => $fvalues) {
                if($value->id == $fvalues->r_id)
                {
                    $fsumma = $fsumma + ($fvalues->m_number * $fvalues->price);
                }

            }
            
            if($summa > $fsumma)
            {
                $foiz = $summa - $fsumma;
                $icon = '<i class="fas fa-angle-double-up mr-1" style="color:#05f705;"></i>';


            }
            elseif($summa == $fsumma)
            {
                $foiz = '';
                $icon = '';
            }
            else
            {
                $foiz = $fsumma - $summa;
                $icon = '<i class="fas fa-angle-double-down mr-1" style="color:#f71505;"></i>';


            }
            $array[] = array('summa' => $summa,'region' => $value->name,'icon' =>$icon);
            $summa = 0;
            $fsumma = 0;

        }
        foreach ($users as $keyf => $valuef) {
            foreach ($sum as $keys => $values) {
                if($valuef->id == $values->u_id)
                {
                    $u_summa = $u_summa + ($values->m_number * $values->price);
                }

            }
            if(isset($valuef->first_name))
                {
                    $userArray[] = array('summa' => $u_summa,'name' => $valuef->last_name.' '.$valuef->first_name);

                }
            $u_summa = 0;

        }

        foreach ($category as $keyfa => $valuefa) {
            foreach ($sum as $keys => $values) {
                if($valuefa->id == $values->c_id)
                {
                    $c_summa = $c_summa + ($values->m_number * $values->price);
                }

            }
            foreach ($fsum as $fkeys => $fvalues) {
                if($valuefa->id == $fvalues->c_id)
                {
                    $fsumma = $fsumma + ($fvalues->m_number * $fvalues->price);
                }

            }
            
            if($c_summa > $fsumma)
            {
                $foiz = $summa - $c_summa;
                $icon = '<i class="fas fa-angle-double-up mr-1" style="color:#05f705;"></i>';


            }
            elseif($c_summa == $fsumma)
            {
                $foiz = '';
                $icon = '';
            }
            else
            {
                $foiz = $fsumma - $c_summa;
                $icon = '<i class="fas fa-angle-double-down mr-1" style="color:#f71505;"></i>';


            }
           
                    $catarray[] = array('summa' => $c_summa,'name' => $valuefa->name,'icon' => $icon);
            $c_summa = 0;

        }
        // arsort( $userArray);
        $sort = $array;
        $sortregionArray=[];
        $sortsummaArray=[];
        
        foreach ($array as $arr) {
            $regionArray[] = $arr['region'];
            $SummaArray[] = $arr['summa'];
        }
        arsort($sort);
        foreach ($sort as $sor) {
            $sortregionArray[] = $sor['region'];
            $sortsummaArray[] = $sor['summa'];
        }
        $sortuser = $userArray;
        $sortusersArray=[];
        $sortusersummaArray=[];
        foreach ($userArray as $uarr) {
            $usersArray[] = $uarr['name'];
            $usersummaArray[] = $uarr['summa'];
        }
        arsort($sortuser);
        foreach ($sortuser as $soru) {
            $sortusersArray[] = $soru['name'];
            $sortusersummaArray[] = $soru['summa'];
        }

        rsort($array);
        rsort($userArray);
        rsort($catarray);
        $newcatarray = [];
        foreach($catarray as $catar)
        {
            $newcatarray[] = array('summa' => number_format($catar['summa'], 0, '', ' '),'name' => $catar['name'],'icon' => $catar['icon']);
        }
        $newarray = [];
        foreach($array as $ar)
        {
            $newarray[] = array('summa' => number_format($ar['summa'], 0, '', ' '),'region' => $ar['region'],'icon' => $ar['icon']);
        }
        $newuserarray = [];
        foreach($userArray as $userar)
        {
            $newuserarray[] = array('summa' => number_format($userar['summa'], 0, '', ' '),'name' => $userar['name']);
        }
        // return [
        //     'a' => $date_begin,
        //     'b' => $date_end,
        //     'c' => $f_date_begin,
        //     'd' => $f_date_end,
        // ];
        return [
            'sregion' => $sortregionArray,
            'ssumma' => $sortsummaArray,
            'region' => $regionArray,
            'summa' => $SummaArray,
            'u_name' => $usersArray,
            'u_summa' => $usersummaArray,
            'su_name' => $sortusersArray,
            'su_summa' => $sortusersummaArray,
            'dashboard' => $newarray,
            'userarry' => $newuserarray,
            'catarray' => $newcatarray,
        ];
    }
}
