<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan; 
use Illuminate\Support\Facades\Config; 

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Province;
use App\Models\District;
use Schema;

class HospitalController extends Controller
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
        $hospitals = Hospital::all();
        return view('admin.hospital.index',compact('hospitals'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'hospital_name' => 'required|max:255',
        ]);
        $data = $request->all();
        $hospital = new Hospital($data);
        $hospital->save();
        if ($hospital) {
            return redirect()->back()->with('message',(__('message.save_success')));
        }else{
            return redirect()->back()->with('message',(__('message.save_error')));
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
        //
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
        $delete = Hospital::find($id)->delete();
        if($delete){
            return redirect()->back()->with('message',(__('message.delete_success')));
        }else{
            return redirect()->back()->with('message',(__('message.delete_error')));
        }
    }
}
