<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.index');
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
