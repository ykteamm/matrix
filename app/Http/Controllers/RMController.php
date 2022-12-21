<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RmService;
use App\Services\ElchiService;
use App\Models\Region;
use DB;

class RMController extends Controller
{
    public $service;
    public function __construct(RmService $service)
    {
        $this->service=$service;
    }
    public function index()
    {
        if(rmDay() == 1) 
        {
            $users = $this->service->users();
            $pharmacy = $this->service->pharmacy();
            $medicine = $this->service->medicine();
            return view('rm.index',compact('users','pharmacy','medicine'));
        }else{
            $users = $this->service->usersT();
            $pharmacy = $this->service->pharmacyT();
            $medicine = $this->service->medicineT();
            return view('rm.live',compact('users','pharmacy','medicine'));
        }
    }
    public function region($region,$time,$action)
    {
        if($region == 'all')
        {
            $id = getRegion();
            $region_name = 'Barchasi';

        }else{
            $id[] = $region;
        $region_name = Region::where('id',$region)->value('name');

        }
        $date = new ElchiService;
        $date = $date->day($time);
        $time_text = $date->dateText;
        $factor = ['Sales','Elchi soni','Check'];

        if($action == 0)
        {
            $users = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_region.id,tg_region.name')
                    ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$date->date_end)
                    ->whereIn('tg_region.id',$id)
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_region.id')->get();
        }
        if($action == 1)
        {
            $users = DB::table('tg_user')
                    ->selectRaw('count(tg_user.region_id) as allprice,tg_region.id,tg_region.name')
                    ->whereIn('tg_user.level',[1,2])
                    ->whereIn('tg_region.id',$id)
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->orderBy('allprice','DESC')
                    ->groupBy('tg_region.id')->get();
        }
        if($action == 2)
        {
            $users = [];
            $r_array[] = (object) array();
            $regions = Region::all();
            $orders = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_order.id as ord_id,tg_region.id as reg_id')
                    ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
                    ->whereDate('tg_productssold.created_at','<=',$date->date_end)
                    ->whereIn('tg_region.id',$id)
                    ->join('tg_order','tg_order.id','tg_productssold.order_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->groupBy('ord_id','reg_id')->get();
                    foreach ($regions as $r => $regiond) {
                        $i=0;
                         $sum=0;
                        foreach ($orders as $o => $order) {
                            if($regiond->id == $order->reg_id)
                            {
                                $i += 1;
                                $sum += $order->allprice;
                            }
                        }
                        if($i != 0)
                            {
                                $users[] = array('allprice' => $sum/$i,'name' => $regiond->name,'id' => $regiond->id);
                            }
                    }
                array_multisort(array_column($users, 'allprice'), $users);
        }
        $regionId = getRegion();
        $regions = Region::whereIn('id',$regionId)->get();

        return view('rm.region',compact('region_name','users','regions','time_text','region','time','action','factor'));
    }

    public function user($region,$time)
    {
        if($region == 'all')
        {
            $id = getRegion();
            $region_name = 'Barchasi';

        }else{
            $id[] = $region;
        $region_name = Region::where('id',$region)->value('name');

        }
        $date = new ElchiService;
        $date = $date->day($time);
        $time_text = $date->dateText;
        $userRegion = getUserRegion();
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id,tg_user.first_name,tg_user.last_name,tg_user.region_id')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.id',$userRegion)
            ->whereIn('tg_user.region_id',$id)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_user.id')->get();

        $regionId = getRegion();
        $regions = Region::whereIn('id',$regionId)->get();
        return view('rm.user',compact('region_name','users','regions','time_text','region','time'));
    }
    public function pharmacy($region,$time)
    {
        if($region == 'all')
        {
            $id = getRegion();
            $region_name = 'Barchasi';

        }else{
            $id[] = $region;
        $region_name = Region::where('id',$region)->value('name');

        }
        $date = new ElchiService;
        $date = $date->day($time);
        $time_text = $date->dateText;
        $userRegion = getUserRegion();
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_pharmacy.id,tg_pharmacy.name')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.region_id',$id)
            ->join('tg_pharmacy','tg_pharmacy.id','tg_productssold.pharm_id')
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_pharmacy.id')->get();

        $regionId = getRegion();
        $regions = Region::whereIn('id',$regionId)->get();
        return view('rm.pharmacy',compact('region_name','users','regions','time_text','region','time'));
    }
    public function medicine($region,$time)
    {
        if($region == 'all')
        {
            $id = getRegion();
            $region_name = 'Barchasi';

        }else{
            $id[] = $region;
        $region_name = Region::where('id',$region)->value('name');

        }
        $date = new ElchiService;
        $date = $date->day($time);
        $time_text = $date->dateText;
        $userRegion = getUserRegion();
            $users = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_medicine.id,tg_medicine.name')
            ->whereDate('tg_productssold.created_at','>=',$date->date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date->date_end)
            ->whereIn('tg_user.region_id',$id)
            ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->orderBy('allprice','DESC')
            ->groupBy('tg_medicine.id')->get();

        $regionId = getRegion();
        $regions = Region::whereIn('id',$regionId)->get();
        return view('rm.medicine',compact('region_name','users','regions','time_text','region','time'));
    }
}
