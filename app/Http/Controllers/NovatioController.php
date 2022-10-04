<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;

class NovatioController extends Controller
{
    public function region(Request $request)
    {
        $inputs = $request->all();
        $time = $inputs['time'];
        
        // if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        // {
        // $regions = DB::table('tg_region')->get();

        // }else{
        //     $r_id_array = [];
        //     foreach (Session::get('per') as $key => $value) {
        //         if (is_numeric($key)){
        //        $r_id_array[] = $key;
        //         }
        //     }

        // }
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
        $userarrayreg = [];

        if ($request->user == 'all') {
            if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $users = DB::table('tg_user')
                    ->where('tg_user.admin',FALSE)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
            else{
                $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
                    $users = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->where('tg_user.admin',FALSE)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
        }
        if ($request->user !== 'all') {
            $userarrayreg[] = $request->user;
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
            // $date_begin = $request->time;
            // $date_end = $request->time;
            // $date_begin = substr($request->time,0,8);
            $date_begin = date('Y-m-d',(strtotime (substr($request->time,0,10) ) ));
            $date_end = date('Y-m-d',(strtotime ( substr($request->time,11) ) ));

            // $date_end = substr($request->time,9);
        }
        // return $date_begin;
        if($inputs['id'] == 'all')
        {
            // if(isset(Session::get('per')['region']))
            // {
            //  if(Session::get('per')['region'] == 'true')
            //  {
                
            //     $region = DB::table('tg_region')->where('id')->get();

            //  }
                
            // }else
            $reid = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->get();

                $region = DB::table('tg_region')->get();

            // }
            $all = [];
                $user = DB::table('tg_productssold')
                ->select('tg_user.id as uid','tg_region.id as tid','tg_order.id as t_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->whereIn('tg_user.id',$userarrayreg)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
                ->where('tg_user.admin',FALSE)

                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_order','tg_order.id','tg_productssold.order_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
        ->orderBy('tg_order.id', 'DESC')

                ->get();
        }else{
            $reid = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            ->where('tg_region.id',$inputs['id'])
            ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->get();

        $user = DB::table('tg_productssold')->where('tg_region.id',$inputs['id'])
        ->select('tg_user.id as uid','tg_region.id as tid','tg_order.id as t_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
        ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->whereIn('tg_user.id',$userarrayreg)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
                ->where('tg_user.admin',FALSE)

        ->join('tg_user','tg_user.id','tg_productssold.user_id')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
        ->join('tg_order','tg_order.id','tg_productssold.order_id')
        ->join('tg_category','tg_category.id','tg_medicine.category_id')

        ->orderBy('tg_order.id', 'DESC')
        ->get();
        }

        if($request->user == 'all')
        {
            return [
                'data' => $user,
                'user' => 'no',
                'reid' => $reid,
            ];
        }
        if($request->user !== 'all')
        {
            $category = DB::table('tg_category')->get();
            $medicine = DB::table('tg_medicine')->get();
            $oneuser = DB::table('tg_productssold')
            ->select('tg_user.id as uid','tg_region.id as tid','tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$date_end)
                    ->whereIn('tg_user.id',$userarrayreg)
                    ->where('tg_category.id','>=',$cate_begin)
                    ->where('tg_category.id','<=',$cate_end)
                    ->where('tg_user.admin',FALSE)

            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
            ->join('tg_category','tg_category.id','tg_medicine.category_id')
            ->get();
            $sum = 0;
            $catesum = 0;
            $medisum = 0;
            $number = 0;
            $cateory = [];
            $medic = [];
            foreach ($oneuser as $key => $one) {
                $sum = $sum + ($one->m_price * $one->m_number);

            }
            foreach ($category as $ckey => $cate) {
                foreach ($oneuser as $key => $one) {

                    if($cate->id == $one->c_id)
                    {
                        $catesum = $catesum + ($one->m_price * $one->m_number);
                        $cateory[$ckey] = array('price' => $catesum, 'name' => $cate->name);
                    }
                }
                    $catesum = 0;
            }
            foreach ($medicine as $mkey => $med) {
                foreach ($oneuser as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic[$mkey] = array('price' => $medisum,'number' => $number, 'name' => $med->name);
                    }
                }
                    $medisum = 0;
                    $number = 0;

            }
            return [
                'data' => $user,
                'sum' => $sum,
                'cateory' => $cateory,
                'medic' => $medic,
                'reid' => $reid,
            ];
        }
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
            // $date_begin = $request->time;
            // $date_end = $request->time;
            $date_begin = date('Y-m-d',(strtotime (substr($request->time,0,10) ) ));
            $date_end = date('Y-m-d',(strtotime ( substr($request->time,11) ) ));

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($request->time,0,10)) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($request->time,11)) ) ));
        }

        
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();

        $myid = 0;
        $regionid = TRUE;

        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }
            if(in_array(Session::get('user')->region_id,$r_id_array))
            {
                $myid = Session::get('user')->region_id;
                $regionid = FALSE;

            }else{
                $regionid = TRUE;
                $myid = 0;
            }

        }
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();


        }else{
            
            $regions = DB::table('tg_region')->whereIn('id',$r_id_array)->get();

        }
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();


        }else{
            
            $regions = DB::table('tg_region')->whereIn('id',$r_id_array)->get();

        }

        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $users = DB::table('tg_user')
        ->where('tg_user.admin',FALSE)
        
        ->get();


        }else{
            $users = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            
            ->whereIn('region_id',$r_id_array)->get();

        }

        // $regions = DB::table('tg_region')->get();
        $category = DB::table('tg_category')->get();
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $sum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_user.admin',FALSE)

                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();

            $fsum = DB::table('tg_productssold')
                    ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                    ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                    ->where('tg_user.admin',FALSE)

                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->join('tg_category','tg_category.id','tg_medicine.category_id')
                    ->get();
        }else{
            
                $sum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereIn('tg_region.id',$r_id_array)
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_user.admin',FALSE)

                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();

            $fsum = DB::table('tg_productssold')
                    ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                    ->where('tg_user.admin',FALSE)

                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->join('tg_category','tg_category.id','tg_medicine.category_id')
                    ->get();
        }

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
                if($fsumma == 0)
                {
                    $foiz = 100;
                    
                }else{
                $foiz = number_format((($summa-$fsumma)*100)/$summa,2);
                }
                $icon = '<i class="fas fa-arrow-up mr-1" style="color:#39f33c;"></i><span style="font-family:Century Gothic";>'.$foiz.'% </span>';



            }
            elseif($summa == $fsumma)
            {
                $foiz = '0';
                $icon = '';
            }
            else
            {
                if($summa == 0)
                {
                    $foiz = 100;
                    
                }else{
                $foiz = number_format((($fsumma-$summa)*100)/$fsumma,2);

                }

                $icon = '<i class="fas fa-arrow-down mr-1" style="color:#f34539;"></i><span style="font-family:Century Gothic";>'.$foiz.'% </span>';


            }
            $array[] = array('summa' => $summa,'region' => $value->name,'icon' =>$icon,'id' => $value->id);
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
                if($fsumma == 0)
                {
                    $foiz = 100;
                    
                }else{
                $foiz = number_format((($c_summa-$fsumma)*100)/$c_summa,2);
                }
                $icon = '<span style="font-family:Gilroy;color:#39f33c;">+'.$foiz.'% </span><i class="fas fa-arrow-up mr-1" style="color:#39f33c;"></i>';

                $detail = 12;

            }
            elseif($c_summa == $fsumma)
            {
                $foiz = '0';
                $icon = '';
                $detail = 1;
            }
            else
            {

                if($fsumma == 0)
                {
                    $foiz = 100;
                    
                }else{
                $foiz = number_format((($fsumma-$c_summa)*100)/$fsumma,2);
                }
                $icon = '<span style="font-family:Gilroy;color:#f34539;">-'.$foiz.'% </span><i class="fas fa-arrow-down mr-1" style="color:#f34539;"></i>';
                $detail = 13;



            }
           
                    $catarray[] = array('detail' => $detail,'summa' => $c_summa,'name' => $valuefa->name,'icon' => $icon);
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
            $number = $catar['summa'];
            if ($number < 999999 && $number > 999) {
                // Anything less than a billion
                $format =  '<span class="numberpr">'.number_format($number / 1000).'</span>' . '<span class="numberkm">K</span>';
            }else if ($number < 999999999 && $number > 999999) {
                // Anything less than a billion
                $format = '<span class="numberpr">'.number_format($number / 1000000,).'</span>' . '<span class="numberkm">M</span>';
            }else {
                $format = number_format($number, 0, '', '.');
            }
            $newcatarray[] = array('detail' => $catar['detail'],'tols'=> number_format($catar['summa'], 0, '', '.'),'summa' => $format,'name' => $catar['name'],'icon' => $catar['icon']);
        }
        $newarray = [];
        foreach($array as $ar)
        {
            $number = $ar['summa'];
             if ($number < 999999 && $number > 999) {
                // Anything less than a billion
                $format = number_format($number / 1000) . 'K';
            }else if ($number < 999999999 && $number > 999999) {
                // Anything less than a billion
                $format = number_format($number / 1000000,) . 'M';
            }else {
                $format = number_format($number, 0, '', '.');
            }
            $newarray[] = array('tols'=> number_format($ar['summa'], 0, '', '.'), 'summa' => $format,'region' => $ar['region'],'icon' => $ar['icon'],'id' =>$ar['id']);
        }
        $newuserarray = [];
        foreach($userArray as $userar)
        {
            $number = $userar['summa'];
            if ($number < 999999 && $number > 999) {
                // Anything less than a billion
                $format = number_format($number / 1000) . 'K';
            }else if ($number < 999999999 && $number > 999999) {
                // Anything less than a billion
                $format = number_format($number / 1000000,) . 'M';
            }else {
                $format = number_format($number, 0, '', '.');
            }
            $newuserarray[] = array('tols'=> number_format($userar['summa'], 0, '', '.'),'summa' => $format,'name' => $userar['name']);
        }
        // return [
        //     'a' => $date_begin,
        //     'b' => $date_end,
        //     'c' => $f_date_begin,
        //     'd' => $f_date_end,
        // ];
        // if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        // {
        //     $sd = 2;
        // }else{
        //     $sd = Session::get('per');
        //     $r_id_array = [];
        //     foreach (Session::get('per') as $key => $value) {
        //         if (is_numeric($key)){
        //        $r_id_array[] = $key;


        //         }
        //     }
        // }
        // fsdfsdf
        return [
            'regid' => Session::get('user')->region_id,
            'myid' => $myid,
            'regionid' => $regionid,
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

    public function calendar(Request $request)
    {
        $save = DB::table('tg_calendar')->insert([
            'year_month' => $request->year_month,
            'day_json' => json_encode($request->day_json),
            'work_day' => intval($request->work_day),
            'created_at' => Carbon::now(),
        ]);
        return $save;

    }

    public function grade(Request $request)
    {
        $grade = $request->ball;
        $user_id = $request->eid;
        $question_id = $request->qid;
        $teacher_id = Session::get('user')->id;

        $exists = DB::table('tg_grade')
        ->where('user_id',$user_id)
        ->where('teacher_id',$teacher_id)
        ->where('question_id',$question_id)
        ->where('created_at',today())
        ->first();
        // return $exists;
        if(!$exists){
            $save = DB::table('tg_grade')->insert([
                'user_id' => $user_id,
                'teacher_id' => $teacher_id,
                'question_id' => $question_id,
                'grade' => $grade,
                'created_at' => Carbon::now(),
                'save' => FALSE
            ]);
            return $save;

        }
        if($exists->save == false){
            $save = DB::table('tg_grade')->where('id',$exists->id)->update([
                'grade' => $grade,
                'created_at' => Carbon::now(),
            ]);
            return $save;
        }
        // if ($save) {
            // return
        // }
    }
    public function gradeSave(Request $request)
    {
        $bool = $request->save;
        $teacher_id = Session::get('user')->id;
        $count = DB::table('tg_grade')
        ->where('teacher_id',$teacher_id)
        ->where('created_at',today())
        ->where('save',false)
        ->get();
        if($bool == 'true')
        {
        if(count($count) > 0 )
        {
            $save = DB::table('tg_grade')
            ->where('created_at',today())
            ->where('teacher_id',$teacher_id)->update([
                'save' => TRUE
            ]);

            return [
                'status' => 200 
            ];
        }
        else{
            return [
                'status' => 300 
            ];

        }  
        }else{
            $save = DB::table('tg_grade')
            ->where('created_at',today())
            ->where('save',FALSE)
            ->where('teacher_id',$teacher_id)->delete();
        }

    }

    public function gradeTashqi(Request $request)
    {
        $cdate = Carbon::now();

        $grade = $request->ygrade;
        $user_id = $request->user['id'];
        $agent_id = $request->agent_array['id'];
        $question_array = $request->a;
        $ques_yulduz = $request->yulduz['id'];
        // return $ques_yulduz;
        $isset = DB::table('tg_cgrade')
        ->where('created_at',$cdate)
        ->where('teacher_id',$agent_id)
        ->where('user_id',$user_id)
        ->get();
        if(count($isset) >= 1)
        {
            return [
                'status' => 200 
            ];
        }else{

        $xy = DB::table('tg_cgrade')
        ->where('teacher_id',$agent_id)
        ->where('user_id',$user_id)
        ->orderBy('id','DESC')
        ->first();
        // return $xy;
        if(isset($xy)){
            $x = [1,2,3];
            $y = [4,5];
            if(in_array($xy->grade,$x))
            {
                $yes = 1;
            }else{
                $yes = 2;
            }
            if(in_array($grade,$x))
            {
                $yes1 = 1;
            }else{
                $yes1 = 2;
            }
            if($yes*$yes1 == 2)
            {
                $savefs = DB::table('tg_cgrade')->insert([
                    'question_id' => $ques_yulduz,
                    'teacher_id' => $agent_id,
                    'user_id' => $user_id,
                    'grade' => $grade,
                    'created_at' => $cdate,
                    'save' => FALSE
                ]);

                if(isset($question_array))
                    {
                        foreach($question_array as $key => $question)
                        {
                            $savefsf = DB::table('tg_clientgrade')->insert([
                                'question_id' => $question,
                                'client_id' => $agent_id,
                                'user_id' => $user_id,
                                'created_at' => $cdate,

                            ]);
                        }
                    }
                    return [
                        'status' => 200 
                    ];
            }else{
                return [
                    'status' => 200 
                ];
            }
        }else{
            $save22 = DB::table('tg_cgrade')->insert([
                'question_id' => $ques_yulduz,
                'teacher_id' => $agent_id,
                'user_id' => $user_id,
                'grade' => $grade,
                'created_at' => $cdate,
                'save' => FALSE

            ]);

            if(isset($question_array))
                {
                    foreach($question_array as $key => $question)
                    {
                        $savere = DB::table('tg_clientgrade')->insert([
                            'question_id' => $question,
                            'client_id' => $agent_id,
                            'user_id' => $user_id,
                            'created_at' => $cdate,

                        ]);
                    }
                }
                return [
                    'status' => 200 
                ];
        }
    }
        
        // if(count($isset) > 1)
        // {

        // }

        
        
        
        

        return [
            'status' => 200 
        ];
    }

}
