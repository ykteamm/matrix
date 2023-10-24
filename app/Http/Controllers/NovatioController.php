<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Models\PurchaseJournal;
use App\Models\User;

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
                    ->where('tg_user.status',1)
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
                    ->where('tg_user.status',1)
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
            ->whereIn('tg_user.status',[0,1])
            ->where('tg_user.rm',0)
            ->orderBy('id','DESC')

            ->select('tg_region.id as tid','tg_user.id','tg_user.username','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->get();

                $region = DB::table('tg_region')->get();

            // }
            $all = [];
                $user = DB::table('tg_productssold')
                ->select('tg_productssold.id as sid','tg_user.id as uid','tg_region.id as tid','tg_order.id as t_id','tg_medicine.name as m_name','tg_productssold.price_product as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->whereIn('tg_user.id',$userarrayreg)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
                ->whereIn('tg_user.status',[0,1])
                ->where('tg_user.rm',0)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_order','tg_order.id','tg_productssold.order_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->orderBy('tg_order.id', 'DESC')
                ->get();
        }else{
            $reid = DB::table('tg_user')
            ->whereIn('tg_user.status',[0,1])
            ->where('tg_user.rm',0)
            ->where('tg_region.id',$inputs['id'])
            ->select('tg_region.id as tid','tg_user.id','tg_user.username','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('id','DESC')

            ->get();

        $user = DB::table('tg_productssold')->where('tg_region.id',$inputs['id'])
        ->select('tg_productssold.id as sid','tg_user.id as uid','tg_region.id as tid','tg_order.id as t_id','tg_medicine.name as m_name','tg_productssold.price_product as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
        ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->where('tg_productssold.medicine_id','>=',$medi_begin)
                ->where('tg_productssold.medicine_id','<=',$medi_end)
                ->whereIn('tg_user.id',$userarrayreg)
                ->where('tg_order.id','>=',$order_begin)
                ->where('tg_order.id','<=',$order_end)
                ->where('tg_category.id','>=',$cate_begin)
                ->where('tg_category.id','<=',$cate_end)
                ->whereIn('tg_user.status',[0,1])
                ->where('tg_user.rm',0)

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
            ->select('tg_user.id as uid','tg_region.id as tid','tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_productssold.price_product as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$date_end)
                    ->whereIn('tg_user.id',$userarrayreg)
                    ->where('tg_category.id','>=',$cate_begin)
                    ->where('tg_category.id','<=',$cate_end)
                    ->where('tg_user.status',1)

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
                        $cateory[$ckey] = array('price' => number_format($catesum,0,'','.'), 'name' => $cate->name);
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

                        $medic[$mkey] = array('price' => number_format($medisum,0,'','.'),'number' => $number, 'name' => $med->name);
                    }
                }
                    $medisum = 0;
                    $number = 0;

            }
            return [
                'data' => $user,
                'sum' => number_format($sum,0,'','.'),
                'cateory' => $cateory,
                'medic' => $medic,
                'reid' => $reid,
            ];
        }
    }
    public function regionChart(Request $request)
    {

        if ($request->time == 'a_today') {
            $date_begin = date_now();
            $date_end = date_now();

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date_now()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date_now()) ) ));
        }
        elseif ($request->time == 'a_week') {
            $date_begin = date_now()->startOfWeek()->format('Y-m-d');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( $date_end) ) ));
        }
        elseif ($request->time == 'a_month') {
            $date_begin = date_now()->startOfMonth()->format('Y-m-d');

            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_end) ) ));
        }
        elseif ($request->time == 'a_year') {
            $date_begin = date_now()->startOfYear()->format('Y-m-d');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_begin) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_end) ) ));
        ;
        }
        elseif ($request->time == 'a_all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');

            $f_date_begin = date_now()->format('1790-01-01');
            $f_date_end = date_now()->format('Y-m-d');
        }
        else{
            $date_begin = date('Y-m-d',(strtotime (substr($request->time,0,10) ) ));
            $date_end = date('Y-m-d',(strtotime ( substr($request->time,11) ) ));

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($request->time,0,10)) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($request->time,11)) ) ));
        }

        // return [
        //     'db'=> $date_begin,
        //     'de'=> $date_end,
        //     'fdb'=> $f_date_begin,
        //     'fde'=> $f_date_end,
        // ];

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
        ->whereIn('tg_user.status',[1,0])
        ->where('tg_user.rm',0)

        ->get();


        }else{
            $users = DB::table('tg_user')
            // ->whereIn('tg_user.status',[1,2])
            ->where('tg_user.rm',0)
            ->whereIn('tg_user.status',[1,0])

            ->whereIn('region_id',$r_id_array)->get();

        }

        // $regions = DB::table('tg_region')->get();
        $category = DB::table('tg_category')->get();
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $sum = DB::table('tg_productssold')
                ->select('tg_productssold.price_product as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->whereIn('tg_user.status',[1,2])
                // ->where('tg_region.id',3)

                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();

            $fsum = DB::table('tg_productssold')
                    ->select('tg_productssold.price_product as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                    ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                    ->whereIn('tg_user.status',[1,2])

                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    ->join('tg_category','tg_category.id','tg_medicine.category_id')
                    ->get();
        }else{

                $sum = DB::table('tg_productssold')
                ->select('tg_productssold.price_product as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                ->whereIn('tg_region.id',$r_id_array)
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->whereIn('tg_user.status',[1,2])
                // ->whereIn('tg_user.status',[18,167,72,175,79,29])
                // ->where('tg_region.id',3)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get();

            $fsum = DB::table('tg_productssold')
                    ->select('tg_productssold.price_product as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id','tg_user.id as u_id','tg_category.id as c_id')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                    ->whereIn('tg_user.status',[1,2])

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
        $asd_summa = [];
        foreach ($regions as $key => $value) {
            foreach ($sum as $keys => $values) {
                if($value->id == $values->r_id)
                {
                    $summa = $summa + ($values->m_number * $values->price);
                }

                foreach ($users as $ke => $va) {
                    if($va->id == $values->u_id && $va->region_id == $value->id)
                    {
                        if(!isset($asd_summa[$value->id][$va->id]))
                        {
                            $asd_summa[$value->id][$va->id] = 0;
                        }
                        $asd_summa[$value->id][$va->id] = $asd_summa[$value->id][$va->id] + ($values->m_number * $values->price);
                    }

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
                $foiz = number_format((($summa-$fsumma)*100)/$fsumma,2);
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
            $ddd = $this->bestMonthSold();

            $rrr = $this->bestRegion($ddd,$value->id);

            if(isset($asd_summa[$value->id]))
            {
                $asdd = $asd_summa[$value->id];
            }else{
                $asdd = [];
            }

            $array[] = array('summa' => $summa,'region' => $value->name,'icon' =>$icon,'id' => $value->id,'best'=>$rrr,'us' => $asdd);
            $summa = 0;
            $fsumma = 0;

        }
        // return $array;
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



        // return $minus_users;
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
            $minus_users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_region.id',$ar['id'])
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('allprice','ASC')
            ->groupBy('tg_user.id','tg_user.first_name','tg_user.last_name')->get();

            $use = [];
            if(date('d') == 1)
            {
                $st = 1;
            }else{
                $st = date('d')-1;
            }
            $en = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->lastOfMonth()->format('d');


            // return $st;
            $proviz = 0;
            $useriz = 0;
            $progi = 0;
            foreach ($ar['us'] as $keyrt => $valuert) {
                $user = User::find($keyrt);
                if($user->specialty_id == 1)
                {
                    $useriz += $valuert;
                }else{
                    $proviz += $valuert;
                }
                $prog = floor(($valuert*$en)/$st);

                $progi += $prog;

                $use[] = array('f' => $user->first_name,'l' => $user->last_name,'id' => $keyrt,'sum' => $valuert,'prog' => $prog);
            }

            $useriz = number_format($useriz,0,',','.');
            $proviz = number_format($proviz,0,',','.');

            $region_name = $ar['region'];

            $find = strpos($region_name," ");
            $v = substr($region_name,$find+1,1);
            if($v == 'v')
            {
                $region_name = substr($region_name,0,$find);
            }

            if ($progi < 999999 && $progi > 999) {
                // Anything less than a billion
                $progi = number_format($progi / 1000) . 'K';
            }else if ($progi < 999999999 && $progi > 999999) {
                // Anything less than a billion
                $progi = number_format($progi / 1000000,) . 'M';
            }else {
                $progi = number_format($progi, 0, '', '.');
            }
            $newarray[] = array('useriz' => $useriz,'proviz' => $proviz,
            'use' => $use,'prog' => $progi, 'best' => $ar['best'],'muser'=>$minus_users,
            'tols'=> number_format($ar['summa'], 0, '', '.'),
            'summa' => $format,'region' => $region_name,
            'icon' => $ar['icon'],'id' =>$ar['id']);
        }
        // return $newarray;
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
        // return $newarray;
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
            'd_begin' => date('d.m.Y',strtotime($date_begin)),
            'd_end' => date('d.m.Y',strtotime($date_end)),
            'fd_begin' => date('d.m.Y',strtotime($f_date_begin)),
            'fd_end' => date('d.m.Y',strtotime($f_date_end))
        ];
    }

    public function calendar(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['day_json'][0]);
        $json = [];
        foreach($inputs['day_json'] as $val)
        {
            $json[]=$val;
        }
        // return $json;

        $save = DB::table('tg_calendar')->insert([
            'year_month' => $request->year_month,
            'day_json' => json_encode($json),
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
    public function editPurchase(Request $request)
    {
        $sid = $request->sid;
        $tid = $request->tid;
        $number = $request->number;


        $first = DB::table('tg_productssold')->where('id',$sid)->first();

        $update = DB::table('tg_productssold')->where('id',$sid)->update([
            'number' => $number,
        ]);
        $new = new PurchaseJournal([
            'user_id' => Session::get('user')->id,
            'sold_id' => $sid,
            'old' => $first->number,
            'new' => $number,
        ]);

        $new->save();



    }
    public function bestMonthSold()
    {
        $b_date = $this->getFirstDate(date('Y-m-d'));
        $b_date = date('Y-m-d',(strtotime ( '-10 day' , strtotime ( $b_date ) ) ));
        $e_date = date('2022-09-01');
        $mustang = [];

        $arrayDate = array();
                $Variable1 = strtotime($b_date);
                $Variable2 = strtotime($e_date);
                $sum = 0;
                for ($currentDate = $Variable1; $currentDate >= $Variable2;$currentDate -= (30*86400))
                {
                    $begin_month = $this->getFirstDate(date('Y-m-d',$currentDate));
                    $end_month = $this->getLastDate(date('Y-m-d',$currentDate));
                   $mustang[] = array('begin' => $begin_month,'end' => $end_month);
                }
        return $mustang;
    }
    public function bestRegion($mustang,$id)
    {
        $arr=[];
        $max=0;
        foreach ($mustang as $key => $value) {
            $sum = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.price_product*tg_productssold.number) as allprice')
                ->where('tg_region.id',$id)
                ->whereDate('tg_productssold.created_at','>=',$value['begin'])
                ->whereDate('tg_productssold.created_at','<=',$value['end'])
                ->whereIn('tg_user.status',[1,2])

                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->get()[0]->allprice;

            if($sum == NULL)
            {
                $sum=0;
            }
            if($sum > $max)
            {
                $max = $sum;
                $index=$value;
            }
        }
        if($max == 0)
        {
            $arr[]=array('date' => 0, 'bestsum' => $max);
        }else{
            $arr[]=array('date' => date('m.Y',strtotime($index['begin'])), 'bestsum' => numb($max),'bestsumText' => $max);
        }

    return $arr;
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

    public function grades(Request $request)
    {
       $month = date('m',strtotime($request->month));
       $year = date('Y',strtotime($request->year));
       $date = date('Y-m',strtotime($request->year.'-'.$request->month));
       $myDate = $date.'-01';
       $begin_day = Carbon::createFromFormat('Y-m-d', $myDate)->startOfMonth()->format('Y-m-d');
       $end_day = Carbon::createFromFormat('Y-m-d', $myDate)->endOfMonth()->format('Y-m-d');
       $dep = $request->dep;
       if($dep == 0){
        $step_question = DB::table('tg_knowledge')->get();
        $all_pill_question = DB::table('tg_pill_questions')->get();
        $know_pill_question = DB::table('tg_knowledge_questions')
        ->select('tg_knowledge_questions.*','tg_pill_questions.id as d_id')
        ->where('tg_knowledge.step',3)
        ->join('tg_condition_questions','tg_condition_questions.id','tg_knowledge_questions.condition_question_id')
        ->join('tg_pill_questions','tg_pill_questions.id','tg_condition_questions.pill_question_id')
        ->join('tg_knowledge','tg_knowledge.id','tg_pill_questions.knowledge_id')
        ->get();

        $all_dates = DB::table('tg_knowledge_grades')
        ->where('user_id',$request->id)
        ->whereDate('created_at','>=',$begin_day)
        ->whereDate('created_at','<=',$end_day)
        ->pluck('created_at');
        $grade_date_array = [];

        foreach($all_dates as $item)
                    {
                        $grade_date_array[] = intval(date('d',strtotime($item)));
                    }
            $grade_date_array = array_unique($grade_date_array);
                $date_array = [];
                for($i=intval(date('d',strtotime($begin_day)));$i<=intval(date('d',strtotime($end_day)));$i++)
                {
                    if(in_array($i,$grade_date_array))
                    {
                        $date_array[] = array('day' => $i,'isset' => 1);

                    }else{
                        $date_array[] = array('day' => $i,'isset' => 0);
                    }
                }
        $grade_array = [];
        $know_grade_array = [];
        foreach($step_question as $key => $value)
        {
            if($value->step == 1)
            {
                $pill_question = DB::table('tg_pill_questions')->where('knowledge_id',$value->id)->get();

                foreach($pill_question as $k => $v)
                {
                    foreach ($grade_date_array as $da => $dat) {
                    $d = date('Y-m-d',strtotime($date.'-'.$dat));
                    $pill_questions = DB::table('tg_knowledge_grades')
                    ->select('tg_knowledge_grades.*','tg_pill_questions.name','tg_user.first_name','tg_user.last_name')
                    ->where('tg_knowledge_grades.user_id',$request->id)
                    ->where('tg_knowledge_grades.pill_id',$v->id)
                    ->whereDate('tg_knowledge_grades.created_at',$d)
                    ->join('tg_pill_questions','tg_pill_questions.id','tg_knowledge_grades.pill_id')
                    ->join('tg_user','tg_user.id','tg_knowledge_grades.teacher_id')
                    ->get();

                    $teacher = DB::table('tg_knowledge_grades')
                    ->select('tg_knowledge_grades.*','tg_pill_questions.name','tg_user.first_name','tg_user.last_name')
                    ->where('tg_knowledge_grades.user_id',$request->id)
                    ->where('tg_knowledge_grades.pill_id',$v->id)
                    ->whereDate('tg_knowledge_grades.created_at',$d)
                    ->join('tg_pill_questions','tg_pill_questions.id','tg_knowledge_grades.pill_id')
                    ->join('tg_user','tg_user.id','tg_knowledge_grades.teacher_id')
                    ->pluck('tg_knowledge_grades.teacher_id');

                    if(count($pill_questions) > 0)
                    {
                        $grade_sum = 0;
                        foreach ($pill_questions as $key => $valuet) {
                            $grade_sum += $valuet->grade;
                        }
                        $avg = $grade_sum/count($teacher);
                    }else{
                        $avg = 0;
                    }
                    if($avg != 0)
                    {
                        $grade_array[] = array('date' => $dat,'avg' => number_format($avg,1),'dep_id' => $v->id,'grades' => $pill_questions);
                    }
                    }

                }

            }

            if($value->step == 3)
            {
                $asd=[];
                $know_question = DB::table('tg_pill_questions')->where('knowledge_id',$value->id)->get();
                foreach ($know_question as $k => $know) {
                    $condition_question = DB::table('tg_condition_questions')->where('pill_question_id',$know->id)->pluck('id');
                    $knowledge_question = DB::table('tg_knowledge_questions')->whereIn('condition_question_id',$condition_question)->pluck('id');
                    foreach ($knowledge_question as $c => $con) {
                        foreach ($grade_date_array as $da => $dat) {
                            $d = date('Y-m-d',strtotime($date.'-'.$dat));
                            $pill_questions = DB::table('tg_knowledge_grades')
                            ->select('tg_knowledge_grades.*','tg_knowledge_questions.name','tg_user.first_name','tg_user.last_name')
                            ->where('tg_knowledge_grades.user_id',$request->id)
                            ->where('tg_knowledge_grades.knowledge_question_id',$con)
                            ->whereDate('tg_knowledge_grades.created_at',$d)
                            ->join('tg_knowledge_questions','tg_knowledge_questions.id','tg_knowledge_grades.knowledge_question_id')
                            ->join('tg_condition_questions','tg_condition_questions.id','tg_knowledge_questions.condition_question_id')
                            ->join('tg_pill_questions','tg_pill_questions.id','tg_condition_questions.pill_question_id')
                            ->join('tg_user','tg_user.id','tg_knowledge_grades.teacher_id')
                            ->get();
                            $teacher = DB::table('tg_knowledge_grades')
                            ->select('tg_knowledge_grades.*','tg_knowledge_questions.name','tg_user.first_name','tg_user.last_name')
                            ->where('tg_knowledge_grades.user_id',$request->id)
                            ->where('tg_knowledge_grades.knowledge_question_id',$con)
                            ->whereDate('tg_knowledge_grades.created_at',$d)
                            ->join('tg_knowledge_questions','tg_knowledge_questions.id','tg_knowledge_grades.knowledge_question_id')
                            ->join('tg_condition_questions','tg_condition_questions.id','tg_knowledge_questions.condition_question_id')
                            ->join('tg_pill_questions','tg_pill_questions.id','tg_condition_questions.pill_question_id')
                            ->join('tg_user','tg_user.id','tg_knowledge_grades.teacher_id')
                            ->pluck('tg_knowledge_grades.teacher_id');

                            if(count($pill_questions) > 0)
                            {
                                $grade_sum = 0;
                                foreach ($pill_questions as $key => $valuet) {
                                    $grade_sum += $valuet->grade;
                                }
                                $avg = $grade_sum/count($teacher);
                            }else{
                                $avg = 0;
                            }
                            if($avg != 0)
                            {
                                $know_grade_array[] = array('date' => $dat,'avg' => number_format($avg,1),'dep_id' => $con,'grades' => $pill_questions);
                            }
                        }
                    }
                }
            }
        }
            return [
                'dep' => 0,
                'grade_array' => $grade_array,
                'know_grade_array' => $know_grade_array,
                'date_array' => $date_array,
                'step_question' => $step_question,
                'all_pill_question' => $all_pill_question,
                'know_pill_question' => $know_pill_question,
            ];
       }else{
            $question_id = DB::table('tg_question')->where('department_id',$dep)->pluck('id');
            $questions = DB::table('tg_question')->where('department_id',$dep)->get();
            $grade_array=[];
            $ff=[];
            foreach ($questions as $key => $value) {
                for($i=intval(date('d',strtotime($begin_day)));$i<intval(date('d',strtotime($end_day)));$i++) {
                    $d = date('Y-m-d',strtotime($date.'-'.$i));
                    $grades = DB::table('tg_grade')
                    ->select('tg_grade.*','tg_question.name','tg_user.first_name','tg_user.last_name')
                    ->where('tg_grade.user_id',$request->id)
                    ->where('tg_grade.question_id',$value->id)
                    ->whereDate('tg_grade.created_at','=',$d)
                    ->join('tg_question','tg_question.id','tg_grade.question_id')
                    ->join('tg_user','tg_user.id','tg_grade.teacher_id')
                    ->get();

                    $teacher_id = DB::table('tg_grade')
                    ->select('tg_grade.*','tg_question.name','tg_user.first_name','tg_user.last_name')
                    ->where('tg_grade.user_id',$request->id)
                    ->where('tg_grade.question_id',$value->id)
                    ->whereDate('tg_grade.created_at','=',$d)
                    ->join('tg_question','tg_question.id','tg_grade.question_id')
                    ->join('tg_user','tg_user.id','tg_grade.teacher_id')
                    // ->distinct('tg_grade.teacher_id')
                    ->pluck('tg_grade.teacher_id');
                    // $techaer_unique = array_unique($teacher_id);
                    if(count($grades) > 0)
                    {
                        $grade_sum = 0;
                        foreach ($grades as $key => $value) {
                            $grade_sum += $value->grade;
                        }
                        $avg = $grade_sum/count($teacher_id);
                    }else{
                        $avg = 0;
                    }
                    if($avg != 0)
                    {
                        $grade_array[] = array('avg' => number_format($avg,1),'q_id' => $value->question_id,'grades' => $grades);
                    }
                }
            }
            $grades = DB::table('tg_grade')
            ->select('tg_grade.*','tg_question.name','tg_user.first_name','tg_user.last_name')
            ->where('tg_grade.user_id',$request->id)
            ->whereIn('tg_grade.question_id',$question_id)
            ->whereDate('tg_grade.created_at','>=',$begin_day)
            ->whereDate('tg_grade.created_at','<=',$end_day)
            ->join('tg_question','tg_question.id','tg_grade.question_id')
            ->join('tg_user','tg_user.id','tg_grade.teacher_id')
            ->orderBy('tg_grade.created_at','ASC')
            ->get();
                $grade_date_array = [];
                foreach($grades as $item)
                {
                    $grade_date_array[] = intval(date('d',strtotime($item->created_at)));
                }
                $grade_date_array = array_unique($grade_date_array);
                $date_array = [];
                for($i=intval(date('d',strtotime($begin_day)));$i<=intval(date('d',strtotime($end_day)));$i++)
                {
                    if(in_array($i,$grade_date_array))
                    {
                        $date_array[] = array('day' => $i,'isset' => 1);

                    }else{
                        $date_array[] = array('day' => $i,'isset' => 0);
                    }
                }

            return [
                'dep' => 1,
                'questions' => $questions,
                'grades' => $grades,
                'date_array' => $date_array,
                'grade_array' => $grade_array,
                'grade_date_array' => $grade_date_array,
            ];
        }
    }
}
