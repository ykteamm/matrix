<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Illuminate\Http\Patient;
use App\Models\District;
use App\Models\Patient;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
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
        return view('dashboard',compact('array'));
    }

    public function filter()
    {
        $regions = DB::table('tg_region')->get();
        $medicine = DB::table('tg_medicine')->get();
        $category = DB::table('tg_category')->get();
        $users = DB::table('tg_user')->get();
        return view('search',compact('regions','medicine','users','category'));
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
