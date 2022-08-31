<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Ekg;
use Illuminate\Support\Facades\Session;


class EkgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('logis');
    }
    public function index()
    {
        

        $ekg_add = DB::table('patients')->select('id','pinfl','last_name','first_name','full_name')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();

        return view('ekg.index', compact('ekg_add'));

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
        
        $id = intval($request->patient_id);
        $json_ekg = json_encode($request->all());

        $diagnos_patient = Patient::where('id', $id)
       ->update([
           'ekg_id' => 1,
        ]);

        $ekg = new Ekg([
            'patient_id' =>  $id,
            'ekg' =>  $json_ekg,
        ]);
        $ekg->save();

        $exo = DB::table('patients')->where('id', $id)->where('exo_id',null)->get();
        $count_exo = count($exo);

        if($count_exo == 0)
        {
            return redirect()->back();
        }
        if ($count_exo == 1) {
            $patient = Patient::where('id', $id)->get();
        return redirect()->back()->with('success', 'ekg_updated')->with('patient',$patient[0]);
        }

        
    // return $request;

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
        //
    }
}
