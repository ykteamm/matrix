<?php

namespace App\Services;

use App\Items\ElchiFunction1Items;
use App\Items\ElchiTimeItems;
use Illuminate\Support\Facades\DB;

class ElchiService
{
    public function day($time)
    {
        if ($time == 'today') {
            $date_begin = date_now();
            $date_end = date_now();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date_now()) ) ));
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = date_now()->format('Y-m-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = date_now()->format('Y-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = date_now()->format('1790-01-01');
            $date_end = date_now()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));
        }
        $item=new ElchiTimeItems();
        $item->date_begin=$date_begin;
        $item->date_end=$date_end;
        $item->dateText=$dateText;
        return $item;
    }

    public function function1($date_begin,$date_end,$id)
    {
        $category = DB::table('tg_category')->get();
        $medicine = DB::table('tg_medicine')->get();
        $medicine_cate = DB::table('tg_medicine')
            ->select('tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_medicine.price as m_price')
            ->join('tg_category','tg_category.id','tg_medicine.category_id')
            ->get();
        $oneuser = DB::table('tg_productssold')
            ->select('tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_productssold.price_product as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_user.id',$id)
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
        $medicineall = [];
        foreach ($medicine_cate as $mkey => $med) {
            $medicineall[$mkey] = array('id' => $med->m_id,'price' => 0,'number' => 0, 'name' => $med->m_name,'cid'=>$med->c_id);

        }
        foreach ($medicine_cate as $mkey => $med) {
            foreach ($oneuser as $key => $one) {

                if($med->m_id == $one->m_id)
                {
                    $medisum = $medisum + ($one->m_price * $one->m_number);
                    $number = $number + $one->m_number;

                    $medicineall[$mkey] = array('id' => $med->m_id,'price' => $medisum,'number' => $number, 'name' => $med->m_name,'cid'=>$one->c_id);
                }
            }
            $medisum = 0;
            $number = 0;

        }
        // return  $medicineall;
        foreach ($medicine as $mkey => $med) {
            foreach ($oneuser as $key => $one) {

                if($med->id == $one->m_id)
                {
                    $medisum = $medisum + ($one->m_price * $one->m_number);
                    $number = $number + $one->m_number;

                    $medic[$mkey] = array('price' => $medisum,'number' => $number, 'name' => $med->name,'cid'=>$one->c_id);
                }
            }
            $medisum = 0;
            $number = 0;

        }
        // return $medic;
        foreach ($oneuser as $key => $one) {
            $sum = $sum + ($one->m_price * $one->m_number);

        }
        foreach ($category as $ckey => $cate) {
            foreach ($oneuser as $key => $one) {
                if($cate->id == $one->c_id)
                {
                    $catesum = $catesum + ($one->m_price * $one->m_number);
                    $cateory[$ckey] = array('price' => $catesum, 'name' => $cate->name,'id' => $cate->id );
                }else{

                }
            }
            // $cateory[] = array('price' => 0, 'name' => $cate->name,'id' => $cate->id );

            $catesum = 0;

        }

        if(count($cateory) == 0)
        {
            foreach ($category as $key => $value) {
                $cateory[] = array('price' => 0, 'name' => $value->name,'id' => $value->id );

            }

        }
        $isar = [];
        foreach($cateory as $key => $value)
        {
            $isar[] = $value['name'];
        }
        foreach ($category as $key => $value) {
            if(!in_array($value->name,$isar))
            {
                $cateory[] = array('price' => 0, 'name' => $value->name,'id' => $value->id );

            }
        }
        $item=new ElchiFunction1Items();
        $item->sum=$sum;
        $item->cateory=$cateory;
        $item->medic=$medic;
        $item->medicineall=$medicineall;
        $item->category=$category;
        return $item;
    }
}
