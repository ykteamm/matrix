<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Illuminate\Http\Patient;
use App\Models\District;
use App\Models\Patient;
use App\Models\Position;
use App\Models\Region;
use Carbon\Carbon;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Jenssegers\Agent\Agent;
// use Session;
// use Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function reg()
    {
        // $email = DB::table('tg_user')->where('id', '36')->value('pr');
        $user = DB::table('tg_productssold')
        ->selectRaw('SUM(tg_productssold.number * tg_medicine.price) as allprice,SUM(tg_productssold.number) as allnumber,tg_medicine.name,tg_medicine.price');
        $search = $user->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id');
               
        // $search = $user->addSelect(DB::raw('count(*) as last'));

        $search = $user->groupBy('tg_medicine.name','tg_medicine.price')->get();


        return $search;
    }
    public function index()
    {
        $regions = DB::table('tg_region')->get();

        $sum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id')
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
        return view('index',compact('array'));
    }

    public function filter()
    {
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        $users = DB::table('tg_user')
        ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->get();
        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }
            $regions = DB::table('tg_region')->whereIn('id',$r_id_array)->get();
            $users = DB::table('tg_user')
            ->whereIn('tg_region.id',$r_id_array)
            ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->get();
        }

        $medicine = DB::table('tg_medicine')->get();
        $category = DB::table('tg_category')->get();
        return view('filter',compact('regions','medicine','users','category'));
    }
    public function elchi($id,$time)
    {
        if ($time == 'today') {
            $date_begin = today();
            $date_end = today();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));

        }  
        // return  substr("$time",0,10);
        $elchi = DB::table('tg_user')->where('tg_user.id',$id)
        ->select('tg_specialty.name as lv','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name','tg_district.name as d_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->join('tg_district','tg_district.id','tg_user.district_id')
        ->join('tg_specialty','tg_specialty.id','tg_user.specialty_id')
        ->first();
        // $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            // $date_end = today()->format('Y-m-d');
            $category = DB::table('tg_category')->get();
            $medicine = DB::table('tg_medicine')->get();
            $oneuser = DB::table('tg_productssold')
            ->select('tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
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
            // return $cateory;
            // return [
            //     'data' => $user,
            //     'sum' => $sum,
            //     'cateory' => $cateory,
            //     'medic' => $medic,
            // ];
        // return $elchi;
        return view('welcome',compact('elchi','medic','cateory','category','sum','dateText'));
        // return $id;
    }
    public function elchiList()
    {
        $userarrayreg = [];
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $users = DB::table('tg_user')
                    ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
        }else{
            $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
                    $users = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            
        }
        $elchi = DB::table('tg_user')
            ->whereIn('tg_user.id',$userarrayreg)
            ->where('tg_user.admin',FALSE)
            ->select('tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('tg_user.admin','DESC')->get();
        return view('elchi',compact('elchi'));
    }
    public function userList(Request $request)
    {
        // $getip = UserSystemInfo::get_ip();
    // $getbrowser = UserSystemInfo::get_browsers();
    // $getdevice = UserSystemInfo::get_device();
    // $getos = UserSystemInfo::get_os();

    // echo "<center>$getip <br> $getdevice <br> $getbrowser <br> $getos</center>";
    // die();
    //  $agent = new Agent();
    //  return $agent->device();
    return php_uname();

        $elchi = DB::table('tg_user')
        ->where('admin',TRUE)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->get();
        // return $elchi;
        $posi = DB::table('tg_positions')->get();
        return view('user',compact('elchi','posi'));
    }
    public function proList($time)
    {
        // $time = '02.09.2022/02.09.2022';
        if ($time == 'today') {
            $date_begin = today();
            $date_end = today();

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-2 week' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( today()) ) ));
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-m-01');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-01-01');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = today()->format('1790-01-01');
            $f_date_end = today()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($time,0,10)) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($time,11)) ) ));
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));

        }  
        $r_id_array = [];

        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        foreach ($regions as $key => $value) {
            // if (is_numeric($key)){
           $r_id_array[] = $value->id;
            // }
        }

        }else{
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        $products = DB::table('tg_productssold')
                ->select('tg_medicine.id as m_id','tg_category.id as c_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->whereIn('tg_region.id',$r_id_array)
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();
        $products_range = DB::table('tg_productssold')
                ->select('tg_medicine.id as m_id','tg_category.id as c_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                ->whereIn('tg_region.id',$r_id_array)
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();

        $category = DB::table('tg_category')->get();
        $medicine = DB::table('tg_medicine')->get();

            $sum = 0;
            $catesum = 0;
            $medisum = 0;
            $number = 0;
            $cateory = [];
            $medic = [];
            $medicf = [];
            $inarray = [];
            foreach ($products as $key => $one) {
                $inarray[] = $one->m_id;
            }
            $inarraycat = [];
            foreach ($products as $key => $one) {
                $inarraycat[] = $one->c_id;
            }
            foreach ($medicine as $mkey => $med) {
                foreach ($products as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic[$mkey] = array('mid'=>$one->m_id,'narx'=>$med->price,'price' => $medisum,'number' => $number, 'name' => $med->name,'cid' => $one->c_id,'nol' => 1);
                    }
                    
            
                }
                    $medisum = 0;
                    $number = 0;

            }
            $medica = $medic;
            $alls = [];
            foreach ($category as $key => $one) {

                foreach ($medicine as $mkey => $med) {
                        $alls[] = array('mid'=>$med->id,'narx'=>$med->price,'price' => 0,'number' => 0, 'name' => $med->name,'cid' => $one->id,'nol' => 0);
                }
            }

            $alls2 = $alls;

            foreach ($alls as $key => $one) {

                foreach ($medica as $mkey => $med) {
                    if($one['cid'] == $med['cid'] && $one['mid'] == $med['mid'] )
                    {
                        $alls2[$key] = $medica[$mkey];
                    }
                }

            }
            foreach ($alls2 as $key => $one) {
                unset($alls2[$key]->mid);
            }
            $medic = $alls2;

            #2
            $medic2 = [];

            foreach ($medicine as $mkey => $med) {
                foreach ($products_range as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic2[$mkey] = array('mid'=>$one->m_id,'narx'=>$med->price,'price' => $medisum,'number' => $number, 'name' => $med->name,'cid' => $one->c_id,'nol' => 1);
                    }
                    
            
                }
                    $medisum = 0;
                    $number = 0;

            }
            $medica2 = $medic2;

            $alls22 = $alls;

            foreach ($alls as $key => $one) {

                foreach ($medica2 as $mkey => $med) {
                    if($one['cid'] == $med['cid'] && $one['mid'] == $med['mid'] )
                    {
                        $alls22[$key] = $medica2[$mkey];
                    }
                }

            }
            // foreach ($alls22 as $key => $one) {
            //     unset($alls22[$key]->mid);
            // }
            $medic2 = $alls22;
            
        return view('product',compact('medic','medic2','category','dateText'));
    }
    public function userOnlineStatus()
    {
        $users = DB::table('tg_user')->where('admin',true)->get();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->first_name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->first_name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }
    public function permission(Request $request)
    {
        $update = DB::table('tg_user')->where('id',$request->user_id)->update(['rol_id' => $request->rol_id]);
        return redirect()->back();
    }
    public function loginSite(Request $request)
    {   
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);
        // $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '@h%';");
        // // return $schema_name;
        // // die();
        // foreach ($schema_name as $key => $value) {
            setSchema('admin');
           

        
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
            }else{
                return redirect()->back();
            }
        // }
        if ($user) {
            Session::put('user', $user);
            $f_schema = $user['branch_key'];
            $h_schema = $user['hospital_key'];
            $id = $user['rol_id'];
            if ($f_schema == 'none') {
                Session::put('pos', 'hospital');
                Session::put('db', $h_schema);
            // $schema_row = DB::select('SELECT * FROM '.'"'."$h_schema".'"'.'.positions WHERE id = '.$id.';');
            $schema_row = Position::find($id);



            }else{
                $admin_schema = 'admin';
                Session::put('pos', 'branch');
                Session::put('db', $f_schema);
                // $schema_row = DB::select('SELECT * FROM '.'"'."$admin_schema".'"'.'.positions WHERE id = '.$id.';');
                $schema_row = Position::find($id);
            }
            // return json_decode($schema_row->position_json);

            // // if (isset($schema_row[0]->position_json)) {
            // //     Session::put('rol', json_decode($schema_row[0]->position_json));
            // // }else{
            //     Session::put('rol', json_decode($schema_row->position_json));
            // // }
            
            setSchemaInConnection();
            $all_patient = DB::table('patients')->count();
    $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')->count();
    $all_true = DB::table('patients')->where('death',true)->count();
    $chkb_true = DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->count();
    $all_false = DB::table('patients')->where('death',false)->count();
    $chkb_false = DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->count();
        // return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
        return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false','user'));
        
            
        }else{ return redirect()->back(); }
            // return $schema_row;
    }

    public function login()
    {
        // Config::set('database.connections.pgsql.schema','public');
        // setSchemaInConnection();


        $all_patient = DB::table('patients')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $all_true = DB::table('patients')->where('death',true)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $chkb_true = DB::table('patients')->where('death',true)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->where('treatment_tip','app.chkb')->count();
        $all_false = DB::table('patients')->where('death',false)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $chkb_false = DB::table('patients')->where('death',false)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->where('treatment_tip','app.chkb')->count();

        return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
        // return view('welcome');
    }
    public function patientExit()
    {

        $patient = Patient::select('id','first_name','last_name','full_name','pinfl')
        ->where('death',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        // $patient = Patient::all();
        // $patient = 'gh';
        return view('patient.exit',compact('patient'));

    }

    // public function login()
    // {
    //     return view('user.login');
    // }
    public function logout()
    {
        // Session::flush();
        // Session::remove('user');
        // $df = Session::get('user');
        // Auth::logout();
        // return $df;
        // return redirect('/login');
        return view('auth.login');
    }

    public function settings()
    {
        return view('user.login');
    }

    

}
