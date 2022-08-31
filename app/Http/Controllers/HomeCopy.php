<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Patient;
use App\Models\District;
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
        $all_patient = DB::table('patients')->count();
        $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')->count();
        $all_true = DB::table('patients')->where('death',true)->count();
        $chkb_true = DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->count();
        $all_false = DB::table('patients')->where('death',false)->count();
        $chkb_false = DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->count();
        return view('dashboard',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
    }
    public function loginSite(Request $request)
    {
        $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '@h%';");

        foreach ($schema_name as $key => $value) {
            setSchemaInConnection($value->schema_name);
           

        
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
            }

            
            
        
        }
        if ($user) {
            Session::put('user', $user);
            $f_schema = $user['branch_key'];
            $h_schema = $user['hospital_key'];
            $id = $user['rol_id'];
            if ($f_schema == 'none') {
                Session::put('pos', 'hospital');
                Session::put('db', $h_schema);
            $schema_row = DB::select('SELECT * FROM '.'"'."$h_schema".'"'.'.positions WHERE id = '.$id.';');


            }else{
                Session::put('pos', 'branch');
                Session::put('db', $f_schema);
                $schema_row = DB::select('SELECT * FROM '.'"'."$f_schema".'"'.'.positions WHERE id = '.$id.';');
            }
            Session::put('rol', json_decode($schema_row[0]->position_json));
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

    public function loginSite2()
    {
        // Config::set('database.connections.pgsql.schema','public');
        setSchemaInConnection();


        $all_patient = DB::table('patients')->count();
        $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')->count();
        $all_true = DB::table('patients')->where('death',true)->count();
        $chkb_true = DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->count();
        $all_false = DB::table('patients')->where('death',false)->count();
        $chkb_false = DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->count();

        return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
           
    }
    public function patientExit()
    {
        setSchemaInConnection();

        $patient = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl')->where('death',null)->get();
        // $patient = 'gh';
        return view('patient.exit',compact('patient'));

    }

    public function login()
    {
        return view('user.login');
    }
    public function logout()
    {
        // Session::flush();
        // Session::remove('db');
        Auth::logout();

        return redirect('/login');
    }

    public function settings()
    {
        return view('user.login');
    }

}
