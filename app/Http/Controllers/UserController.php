<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Branch;
use App\Models\Position;
// use Schema;
use Illuminate\Support\Facades\Artisan;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth'); 
    }
    public function index()
    {
        $users = User::with('rol','hospital','branch')->get();
        return view('admin.user.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals = Hospital::all();
        $positions = Position::all();
        return view('admin.user.create',compact('hospitals','positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required',
            'branch_id' => 'required',
            'rol_id' => 'required',
            'user_name' => 'required|max:255',
            'user_adress' => 'required|max:255',
            'user_phone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);
        $data = $request->all();
        if ($request->branch_id == 'null') {
            unset($data['branch_id']);
        }
        // return $data;
        $data['password'] = Hash::make($request->password);
        $user = new User($data);
        $user->save();
        if ($user) {
            return redirect()->route('user.index')->with('message',(__('message.save_success')));
        }else{
            return redirect()->route('user.index')->with('message',(__('message.save_error')));
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        setSchemaInConnection();
        if (Session::get('pos') == 'hospital') {

            $user = DB::table('users')->join('positions','positions.id','users.rol_id')->where('users.id',$id)->get();
            
            // return view('user.create',compact('rol','b_name','hos_name','all_user'));

        }
        if(Session::get('pos') == 'branch')
        {
            $user = DB::table('users')->where('users.branch_name','!=','none')->where('users.id',$id)->get();
            // return view('user.create',compact('rol','all_user'));

        }
        return view('user.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // setSchemaInConnection();
        // setSchema('admin');
        // $user = User::find($id);
        // $user->delete();
        // setSchemaInConnection();
        // $user = User::find($id);
        // $user->delete();

        return redirect()->back();
        // request ;
        // return [
        //     's' => 'ff',
        // ];
        // dd($id);
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
        // return $request;

        // return $request;
        setSchema('admin');

        // if ($request->branch == 'none') {
        //     setSchema($request->hospital);
        //     // Config::set('database.connections.pgsql.schema',$request->hospital);
        // }

        // else{ setSchema($request->branch); }

        $s_h_name = DB::select('SELECT * FROM '.'"'."$request->hospital".'"'.'.hospitals;');
        $h_name = $s_h_name[0]->h_name;
        if ($request->branch == 'none') {
            $b_name = 'none';
        }else{
            $s_b_name = DB::select('SELECT * FROM '.'"'."$request->branch".'"'.'.branches;');
            $b_name = $s_b_name[0]->b_name;

        }
        // if (count($s_b_name) > 0) {
        //     $b_name = $s_b_name[0]->b_name;
        // }else{
        //     $b_name = 'none';
        // }
        $password = Hash::make($request->password);



        // $created = new User([
        //     'hospital_name' => $h_name,
        //     'hospital_key' => $request->hospital,
        //     'branch_name' => $b_name,
        //     'branch_key' => $request->branch,
        //     'rol_id' => $request->rol_id,
        //     'user_name' => $request->user_name,
        //     'user_phone' => $request->phone,
        //     'user_adress' => $request->adress,
        //     'email' => $request->email,
        //     'password' => $password,
        // ]);
        // $created->save();
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

        return redirect()->back();
    }

}

