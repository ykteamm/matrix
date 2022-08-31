<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Session;

class ExchangeController extends Controller
{
    public function exchange()
    {
        return view('exchange.index');
    }
    public function exchangeRequest(Request $request)
    {
        $data = $request->all();
        if(Session::get('hospital_id') == NULL)
        {
            $patient_branch = Patient::where('pinfl',$data['pinfl'])
            ->where('patients.branch_id','!=',Session::get('branch_id'))
            ->join('branches','branches.id','patients.branch_id')
            ->join('hospitals','hospitals.id','branches.hospital_id')
            ->get();

            $patient_hospital = Patient::where('pinfl',$data['pinfl'])
            ->where('branch_id',NULL)
            ->join('hospitals','hospitals.id','patients.hospital_id')
            ->join('branches','branches.hospital_id','patients.hospital_id')
            ->get();
        }
        if(Session::get('branch_id') == NULL)
        {
            $patient_hospital = Patient::where('pinfl',$data['pinfl'])
            ->where('patients.hospital_id','!=',Session::get('hospital_id'))
            ->join('hospitals','hospitals.id','patients.hospital_id')
            ->get();

            $patient_branch = Patient::where('pinfl',$data['pinfl'])
            ->where('patients.hospital_id',NULL)
            ->join('branches','branches.id','patients.branch_id')
            ->join('hospitals','hospitals.id','branches.hospital_id')
            ->get();
        }
        // return $patient_branch;
        return view('exchange.list',compact('patient_hospital','patient_branch'));

    }

}
