<?php

namespace App\Http\Controllers;

use App\Models\McOrder;
use App\Models\Pharmacy;
use App\Models\Region;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function admin()
    {
        $regions = Region::pluck('name','id')->toArray();
        $pharmacy = Pharmacy::pluck('name','id')->toArray();
        $orders = McOrder::pluck('number','id')->toArray();


        $money = new AdminService;

        $sitafor = $money->orderMoneyArrive();

        // $qarzdorlik = $money->qarzdorlik();

        // dd($sitafor);
        // dd(array_sum($sitafor));

        $arrive_monay = $money->arriveMoney();

        $arrive_monay = 486614417;

        $arrive_monay_day = $money->arriveMoneyToday();
        $arrive_monay_week = $money->arriveMoneyWeek();

        $shipment = $money->shipment();

        $shipment_day = $money->shipmentDay();
        $shipment_week = $money->shipmentWeek();

        $rekom = $money->rek();

        $qizil_rek = 0;
        $qizil_rek_sum = 0;

        $sariq_rek = 0;
        $sariq_rek_sum = 0;

        $yashil_rek = 0;
        $yashil_rek_sum = 0;

        $yashil_region = [];
        $sariq_region = [];
        $qizil_region = [];

        $dd = [];

        

        $yashil = [];
        $sariq = [];
        $qizil = [];

        $yashil_all = 0;
        $sariq_all = 0;
        $qizil_all = 0;

        $yashil_p = [];
        $sariq_p = [];
        $qizil_p = [];

        $yashil_mc = [];
        $sariq_mc = [];
        $qizil_mc = [];

        $sariq_soni = [];
        $qizil_soni = [];



        $qizil_yangi = [];
        $qizil_eski = [];

        $qizil_yangi_sum = 0;
        $qizil_eski_sum = 0;

        $sariq_yangi_sum = 0;
        $sariq_eski_sum = 0;

        $yashil_yangi_sum = 0;
        $yashil_eski_sum = 0;

        $viloyat = [];

        $yashil = [];
        $yashil_all = 0;
        $yashil_all_p = 0;

        $ffgghh = [];
        
        foreach ($sitafor as $a => $sitaf) {
            foreach ($sitaf as $f => $sita) {

                $yashil_all_p = 0;
                $sariq_all_p = 0;
                $qizil_all_p = 0;

                foreach ($sita as $k => $sitf) {

                    
                    if(isset($sitf[3]))
                    {
                        foreach ($sitf[3] as $t => $v) {
                            if($v['xolat'] == 2)
                            {
                                $qizil[$a][] = $v['qarz'];
                                $qizil_all += $v['qarz'];
                                $qizil_all_p += $v['qarz'];

                                $qizil_mc[$k][$t] = $v['qarz'];
                                $qizil_soni[$t] = $v['kun'];

                                if($v['pul_xolat'] == 1)
                                {
                                    $qizil_yangi[$k][] = $v['qarz'];
                                    $qizil_yangi_sum += $v['qarz'];
                                    $viloyat[$a][] = $v['qarz'];


                                }else{
                                    $qizil_eski[$k][] = $v['qarz'];
                                    $qizil_eski_sum += $v['qarz'];


                                }

                            }elseif($v['xolat'] == 1){

                                $sariq[$a][] = $v['qarz'];
                                $sariq_all += $v['qarz'];
                                $sariq_all_p += $v['qarz'];

                                $sariq_mc[$t] = $v['qarz'];
                                $sariq_soni[$t] = $v['kun'];

                                if($v['pul_xolat'] == 1)
                                {
                                    $sariq_yangi_sum += $v['qarz'];
                                    $viloyat[$a][] = $v['qarz'];

                                }else{
                                    $sariq_eski_sum += $v['qarz'];

                                }

                            }else{
                                if($v['pul_xolat'] == 1)
                                {
                                    $yashil[$a][] = $v['qarz']  ;
                                    $yashil_all += $v['qarz']   ;
                                    $yashil_all_p += $v['qarz'] ;


                                    $yashil_yangi_sum += $v['qarz'];
                                    $viloyat[$a][] = $v['qarz'];

                                    $ffgghh[$a][$sitf][] = $v['qarz'];

                                }else{
                                    $yashil_eski_sum += $v['qarz'];

                                }

                            }
                        
                            
                        }
                        // $qarz[$a][] = $sitf[1];

                    }



                }

                
                $yashil_p[$f] = $yashil_all_p;
                $qizil_p[$f] = $qizil_all_p;
                $sariq_p[$f] = $sariq_all_p;

                $yashil_all_p = 0;
                $qizil_all_p = 0;
                $sariq_all_p = 0;


            }
        }
        dd($ffgghh[2]);
        // $hh = [];
        // foreach ($viloyat as $key => $value) {
        //     $hh[Region::find($key)->name] = array_sum($value);
        // }
        // dd($hh);
        // dd(array_sum($viloyat[8]));
        // dd(array_sum($viloyat[2]));

        foreach ($rekom as $key => $value) {
            if($value['con'] == 2)
            {
                $yashil_rek += 1;
                $yashil_rek_sum += $value['sum'];
            }
            if($value['con'] == 1)
            {
                $sariq_rek += 1;
                $sariq_rek_sum += $value['sum'];
            }
            if($value['con'] == 0)
            {
                $qizil_rek += 1;
                $qizil_rek_sum += $value['sum'];
            }

            $pharm = Pharmacy::find($key);
            foreach ($regions as $r => $reg) {
                if($r == $pharm->region_id)
                {
                    if($value['con'] == 2)
                    {
                        $yashil_region[$r][] = $value['sum'];
                        $dd[] = $key;

                    }

                    if($value['con'] == 1)
                    {
                        $sariq_region[$r][] = $value['sum'];
                    }

                    if($value['con'] == 0)
                    {
                        $qizil_region[$r][] = $value['sum'];
                    }

                }
            }
        }

        // dd($sitafor);

        

        return view('admin.index',[
            'qizil_yangi_sum' => $qizil_yangi_sum,
            'qizil_eski_sum' => $qizil_eski_sum,

            'sariq_yangi_sum' => $sariq_yangi_sum,
            'sariq_eski_sum' => $sariq_eski_sum,

            'yashil_yangi_sum' => $yashil_yangi_sum,
            'yashil_eski_sum' => $yashil_eski_sum,

            'yashil' => $yashil,
            'sariq' => $sariq,
            'qizil' => $qizil,

            'yashil_all' => $yashil_all,
            'sariq_all' => $sariq_all,
            'qizil_all' => $qizil_all,

            'yashil_p' => $yashil_p,
            'sariq_p' => $sariq_p,
            'qizil_p' => $qizil_p,
            
            'sariq_mc' => $sariq_mc,
            'qizil_mc' => $qizil_mc,

            'sariq_soni' => $sariq_soni,
            'qizil_soni' => $qizil_soni,

            'regions' => $regions,
            'pharmacy' => $pharmacy,
            'orders' => $orders,

            'sitafor' => $sitafor,

            'arrive_monay' => $arrive_monay,
            'arrive_monay_day' => $arrive_monay_day,
            'arrive_monay_week' => $arrive_monay_week,

            'shipment' => $shipment,
            'shipment_day' => $shipment_day,
            'shipment_week' => $shipment_week,

            'yashil_rek_sum' => $yashil_rek_sum,
            'sariq_rek_sum' => $sariq_rek_sum,
            'qizil_rek_sum' => $qizil_rek_sum,

            'yashil_region' => $yashil_region,
            'sariq_region' => $sariq_region,
            'qizil_region' => $qizil_region,
        ]);
    }

    public function adminLogin()
    {
        return view('admin.login');
    }

    public function adminList(Request $request)
    {
        $elchi = DB::table('tg_user')
            ->where('admin', TRUE)
            // ->where('rm', 0)
            ->select('tg_user.last_seen', 'tg_positions.id as pid', 'tg_positions.rol_name', 'tg_user.id', 'tg_user.tg_id', 'tg_user.username', 'tg_user.birthday', 'tg_user.phone_number', 'tg_user.first_name', 'tg_user.last_name', 'tg_region.name as v_name')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftjoin('tg_positions', 'tg_positions.id', 'tg_user.rol_id')
            ->orderBy('tg_user.last_seen', 'ASC')
            ->get();
        $posi = DB::table('tg_positions')->get();
        return view('admin.pages.rol', compact('elchi', 'posi'));
    }

    public function adminListEdit($id)
    {
        $per = DB::table('tg_positions')->where('id',$id)->first();
        $rol_name = $per->rol_name;
        $per_json = $per->position_json;
        $per_json =  json_decode($per_json);
        unset($per_json->rol_name);
        unset($per_json->_token);
        $positions = h_positions();

        
        $per_json = $this->object_to_array($per_json);
        return view('admin.pages.rol-edit',compact('positions','rol_name','per_json','id'));
    }

    public function adminListUpdate(Request $request, $id)
    {

        
        $data = $request->all();

        $position = DB::table('tg_positions')->where('id', $id)->update(array(
            'position_json' => json_encode($request->all()),
            'rol_name' => $data['rol_name'],
            'update_at' => today()
        ));

       
        
        return redirect()->route('super-admin-list');
        
    }

    public function adminListEditSecret($id)
    {
        $per = DB::table('tg_user')->where('id',$id)->first();
        // $rol_name = $per->rol_name;
        $per_json = $per->position;
        $per_json =  json_decode($per_json);


        $positions = admin_positions();

        $per_json = $this->object_to_array($per_json);

        return view('admin.pages.super-rol-edit',compact('positions','per_json','id'));
    }


    public function adminListUpdateSecret(Request $request, $id)
    {

        
        $data = $request->all();

        unset($data['_token']);
        

        $position = DB::table('tg_user')->where('id', $id)->update(array(
            'position' => json_encode($data),
        ));

       
        return redirect()->route('super-admin-list');
        
    }

    public function object_to_array($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = [];
            foreach ($data as $key => $value)
            {
                $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
            }
            return $result;
        }
        return $data;
    }


    public function logoutAdmin(Request $request)
    {
        Session::remove('admin_user');

        return redirect()->route('admin-index');
    }
}
