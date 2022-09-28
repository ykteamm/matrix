<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Facades\Session;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;


class PositionController extends Controller
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
        
        $positions = DB::table('tg_positions')->get();
        return view('admin.position.list',compact('positions'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = h_positions();
        return view('admin.position.index',compact('positions'));
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
            'rol_name' => 'required|max:255|unique:positions',
        ]); 
        $data = $request->all(); 
        
        $data['added_by'] = 1;
        $data['position_json'] = $request->all();
        // return $data;
        $position = DB::table('tg_positions')->insert(array(
            'position_json' => json_encode($data['position_json']),
            'rol_name' => $data['rol_name'],
            'created_at' => Carbon::now(),
            'update_at' => Carbon::now()
        ));
        if ($position) {
            return redirect()->route('position.index')->with('message',(__('message.save_success')));
        }else{
            return redirect()->route('position.index')->with('message',(__('message.save_error')));
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
        // return $id;
        $per = DB::table('tg_positions')->where('id',$id)->first();
        $rol_name = $per->rol_name;
        $per_json = $per->position_json;
        $per_json =  json_decode($per_json);
        unset($per_json->rol_name);
        unset($per_json->_token);
        $positions = h_positions();

        function object_to_array($data)
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
        $per_json = object_to_array($per_json);
        return view('admin.position.edit',compact('positions','rol_name','per_json','id'));
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
      
        // $request->validate([
        //     'rol_name' => 'required|max:255|unique:positions',
        // ]); 
        $data = $request->all(); 
    //     $position = Position::where('id', $id)
    //    ->update([
    //        'position_json' => $request->all(),
    //        'rol_name' => $data['rol_name']
    //     ]);

        $position = DB::table('tg_positions')->where('id', $id)->update(array(
            'position_json' => json_encode($request->all()),
            'rol_name' => $data['rol_name'],
            'update_at' => today()
        ));
        // Session::put('per', $request->all());

        // $position = new Position($data);
        // $position->save();
        if ($position) {
            return redirect()->route('position.index')->with('message',(__('message.save_success')));
        }else{
            return redirect()->route('position.index')->with('message',(__('message.save_error')));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Position::find($id)->delete();
        if($delete){
            return redirect()->back()->with('message',(__('message.delete_success')));
        }else{
            return redirect()->back()->with('message',(__('message.delete_error')));
        }
    }
}
