<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Hash; 
use App\Models\Position;
use App\Models\Rol;
use App\Models\User;
// use App\helpers;

// use Session;
class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); 
    }
    public function index()
    {
        // Session::put('success') = 'patient_create';
        // Session::put('vov', 'money');

        return view('admin.index');
    }

    public function createUser()
    {
        $schema_name = DB::select('SELECT schema_name
        FROM information_schema.schemata;');

        $schema_h = [];
        $schema_h_h = [];

        
        for ($i=1; $i <=count($schema_name) ; $i++) { 
            $schema_h[] = '@h'.$i.'%';

        }
        foreach ($schema_name as $key => $value) {
            foreach ($schema_h as $keys => $values) {
                if ($value->schema_name == $values) {
                    $schema_h_h[] = $value->schema_name;
                }
            }
            
        }
        $h_name = [];
        foreach ($schema_h_h as $key => $value) {
            $schema_row = DB::select('SELECT * FROM '.'"'."$value".'"'.'.hospitals;');
                $h_name[$value] = $schema_row[0]->h_name;
            }
        return view('admin.user.create',compact('h_name'));
    }
    public function getBranch(Request $request)
    {
        $h_name = $request->data;
        $h_name_sub = substr($request->data,0,-1);
        $h_name_sub = $h_name_sub.'_f%';

        $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '$h_name_sub';");
        $h_name = [];
        foreach ($schema_name as $key => $value) {
            $valu = $value->schema_name;
            $schema_row = DB::select('SELECT * FROM '.'"'."$valu".'"'.'.branches;');
                $h_name[$valu] = $schema_row[0]->b_name;
            }
        return [
            'data' => $h_name
        ];
    }

    

    
    public function listRol()
    {
        setSchema('admin');
        $listRol = Position::select('id','role_name')->get();   
        return view('admin.position.list', compact('listRol'));
    }


    public function hasUser(Request $request)
    {   
        setSchema('admin');
        $listRol = Position::select('id','role_name')->get();   
        // return view('admin.position.list', compact('listRol'));
        // $valu = $request->data;
        // $schema_row = DB::select('SELECT id,role_name FROM '.'"'."$valu".'"'.'.positions;');

        return [
            'data' => $listRol,
        ];
    }

    public function hasUserEmail(Request $request)
    {
        $email = $request->data;
        
        $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '@h%';");

        foreach ($schema_name as $key => $value) {
            $email_table = DB::select('SELECT email FROM '.'"'."$value->schema_name".'"'.'.users;');
            foreach ($email_table as $key => $value) {
                if($value->email == $email){
                    $message = 'false';
                    if($message == 'false'){
                        break;
                    }
                }
                else{
                    $message = 'true';
                }
            }
           

        }

        return [
            'data' => $message,
        ];
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'hospital' => 'required|max:255',
            'branch' => 'required|max:255',
            'rol_id' => 'required|max:255',
            'user_name' => 'required|max:255',
            'adress' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        if ($request->branch == 'none') {
            setSchema($request->hospital);
            // Config::set('database.connections.pgsql.schema',$request->hospital);
        }

        else{ setSchema($request->branch); }

        $s_h_name = DB::select('SELECT * FROM '.'"'."$request->hospital".'"'.'.hospitals;');
        $h_name = $s_h_name[0]->h_name;
        if($request->branch == 'none')
        {
            $b_name = 'none';
        }
        else{ $s_b_name = DB::select('SELECT * FROM '.'"'."$request->branch".'"'.'.branches;');
        $b_name = $s_b_name[0]->b_name;}

        $password = Hash::make($request->password);



        $created = new User([
            'hospital_name' => $h_name,
            'hospital_key' => $request->hospital,
            'branch_name' => $b_name,
            'branch_key' => $request->branch,
            'rol_id' => $request->rol_id,
            'user_name' => $request->user_name,
            'user_phone' => $request->phone,
            'user_adress' => $request->adress,
            'email' => $request->email,
            'password' => $password,
        ]);
        $created->save();
        setSchema('admin');
        $created = new User([
            'hospital_name' => $h_name,
            'hospital_key' => $request->hospital,
            'branch_name' => $b_name,
            'branch_key' => $request->branch,
            'rol_id' => $request->rol_id,
            'user_name' => $request->user_name,
            'user_phone' => $request->phone,
            'user_adress' => $request->adress,
            'email' => $request->email,
            'password' => $password,
        ]);
        $created->save();        

        // $schema_db = '"public"'.'.users';
        // $create = DB::statement("INSERT INTO $schema_db(hospital_name,hospital_key,branch_name,branch_key,rol_id,user_name,user_phone,user_adress,email,password) VALUES('$h_name','$request->hospital','$b_name','$request->branch','$request->rol_id','$request->user_name','$request->phone','$request->adress','$request->email','$password');");

        return redirect()->route('list_user');
    }

    public function listUser()
    {
        setSchema('admin');
        $listUser = User::with('rol')->get();
        // foreach ($listUser as $key => $value) {
            // echo '<pre>';
            // print_r($listUser);
            // echo '<pre>';

        // }
        return view('admin.user.list', compact('listUser'));
    }
    public function editUser($id)
    {
        setSchema('admin');
        $user = User::with('rol')->find($id);
        $schema_name = DB::select('SELECT schema_name
        FROM information_schema.schemata;');

        $schema_h = [];
        $schema_h_h = [];

        
        for ($i=1; $i <=count($schema_name) ; $i++) { 
            $schema_h[] = '@h'.$i.'%';

        }
        foreach ($schema_name as $key => $value) {
            foreach ($schema_h as $keys => $values) {
                if ($value->schema_name == $values) {
                    $schema_h_h[] = $value->schema_name;
                }
            }
            
        }
        $h_name = [];
        foreach ($schema_h_h as $key => $value) {
            $schema_row = DB::select('SELECT * FROM '.'"'."$value".'"'.'.hospitals;');
                $h_name[$value] = $schema_row[0]->h_name;
            }

        $b_name = $user['hospital_key'];
        
        $h_name_sub = substr($b_name,0,-1);
        $h_name_sub = $h_name_sub.'_f%';

        $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '$h_name_sub';");
        $b_name_array = [];
        foreach ($schema_name as $key => $value) {
            $valu = $value->schema_name;
            $schema_row = DB::select('SELECT * FROM '.'"'."$valu".'"'.'.branches;');
                $b_name_array[$valu] = $schema_row[0]->b_name;
            }
        $b_name_array['none'] = $user['hospital_name'];
        setSchema('admin');
        $listRol = Position::select('id','role_name')->get(); 
        return view('admin.user.edit',compact('user','h_name','listRol','b_name_array'));

    }
    public function deleteUser($id)
    {
        setSchema('admin');
        $user = User::find($id);
        if ($user['branch_name'] == 'none') {
            $db = $user['hospital_key'];
            $name = $user['user_name'];
            $mail = $user['email'];
        }else{
            $db = $user['branch_key'];
            $name = $user['user_name'];
            $mail = $user['email'];
        }
        $user = User::find($id);
        $user->delete();

        setSchema($db);
        $user = User::where('user_name',$name)->where('email',$mail)->delete();
       
        
        return redirect()->back();
    }
    public function updateUser(Request $request,$id)
    {
        if ($request->branch == 'none'){
            $db = $request->hospital;
        }else{ 
            $db = $request->branch; 
        }

        $s_h_name = DB::select('SELECT * FROM '.'"'."$request->hospital".'"'.'.hospitals;');
        $h_name = $s_h_name[0]->h_name;
        if($request->branch == 'none')
        {
            $b_name = 'none';
        }
        else{ $s_b_name = DB::select('SELECT * FROM '.'"'."$request->branch".'"'.'.branches;');
        $b_name = $s_b_name[0]->b_name;}

        $password = Hash::make($request->password);
        // foreach ($for as $key => $value) {
 
            setSchema('admin');
            
            // $getUser = User::find($id);
            // $userName = $getUser->user_name;
            // $userPhone = $getUser->user_phone;
            // return $request;

             User::where('id',$id)
            ->update([
                'hospital_name' => $h_name,
                'hospital_key' => $request->hospital,
                'branch_name' => $b_name,
                'branch_key' => $request->branch,
                'rol_id' => $request->role_id,
                'user_name' => $request->user_name,
                'user_phone' => $request->phone,
                'user_adress' => $request->adress,
                'email' => $request->email,
                'password' => $password,
                ]);
        // }
        // return $for;
        return redirect()->route('list_user');
    }
}
