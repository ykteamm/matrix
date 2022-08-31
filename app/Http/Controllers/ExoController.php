<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Exo;
use Illuminate\Support\Facades\Session;


class ExoController extends Controller
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
        

        $exo_add = DB::table('patients')->select('id','pinfl','last_name','first_name','full_name')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();

        return view('exo.index', compact('exo_add'));
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
        $json_exo = json_encode($request->all());

        $diagnos_patient = Patient::where('id', $id)
       ->update([
           'exo_id' => 1,
        ]);

        $exo = new Exo([
            'patient_id' =>  $id,
            'exo' =>  $json_exo,
        ]);
        $exo->save();

        $treatment = DB::table('patients')->where('id', $id)->where('treatment',null)->get();
        $count_treatment = count($treatment);

        if($count_treatment == 0)
        {
            return redirect()->back();
        }
        if ($count_treatment == 1) {
            $patient = Patient::where('id', $id)->get();
        return redirect()->back()->with('success', 'exo_updated')->with('patient',$patient[0]);
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
        //
    }
}
