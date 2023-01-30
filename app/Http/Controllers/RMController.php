<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RmService;
use App\Services\ElchiService;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class RMController extends Controller
{
    public $service;
    public function __construct(RmService $service)
    {
        $this->service=$service;
    }
    public function index()
    {
        
            $users = $this->service->usersT();
            $pharmacy = $this->service->pharmacyT();
            $medicine = $this->service->medicineT();

            $regions = DB::table('tg_region')->get();

            $sum = DB::table('tg_productssold')
                    ->select('tg_productssold.price_product as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id')
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                    // ->orderBy('tg_order.id', 'ASC')
                    ->get();
            $summa = 0;
            $array = [];
            foreach ($regions as $key => $value) {
                foreach ($sum as $keys => $values) {
                    if($value->id == $values->r_id)
                    {
                        $summa = $summa + ($values->m_number * $values->price);
                    }
    
                }
    
                $array[] = array('summa' => $summa,'region' => $value->name);
                $summa = 0;
    
            }
            arsort( $array);
            if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $usersssss = DB::table('tg_user')
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
                    $userssss = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->where('tg_user.status',1)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($userssss as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
        $hisob = DB::table('tg_shift')
        ->select('tg_shift.*','tg_user.first_name','tg_user.last_name','tg_user.phone_number','tg_region.name','tg_user.username')
        ->join('tg_user','tg_user.id','tg_shift.user_id')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->whereIn('tg_user.id',$userarrayreg)
        ->whereDate('tg_shift.open_date',Carbon::now())
        ->get();

        
        $nowork = DB::table('tg_shift')
        ->select('tg_shift.*','tg_user.first_name','tg_user.last_name','tg_user.phone_number','tg_region.name','tg_user.username')
        ->join('tg_user','tg_user.id','tg_shift.user_id')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->whereIn('tg_user.id',$userarrayreg)
        ->whereDate('tg_shift.open_date',Carbon::now())
        ->pluck('tg_shift.user_id')->toArray();
        // return $hisob;
        $nowork = DB::table('tg_user')
        ->select('tg_user.*','tg_region.name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->whereNotIn('tg_user.id',$nowork)
        ->whereIn('tg_user.id',$userarrayreg)
        ->get();
            return view('rm.index',compact('users','pharmacy','medicine','array','nowork','hisob'));
        
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
