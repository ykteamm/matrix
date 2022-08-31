<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Province;
class DistrictController extends Controller
{
    public function getDistrict(Request $request)
    {

        $id = $request->data;
        $district = District::where('province_id',$id)
        ->get();
        return [
            'district' => $district,
        ];
        // return [
        //     'success' => $request->data,
        // ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setSchemaInConnection();

        $province = Province::all();
        $district = DB::table('districts')->select('districts.id','districts.district_name','provinces.province_name')
        ->join('provinces','districts.province_id','provinces.id')
        ->get();

        return view('district.index', compact('district','province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        setSchemaInConnection();

        $request->validate([
            'district'=>'required',
            'province_id'=>'required',
        ]);

        $district = new District([
            'district_name' => $request->get('district'),
            'province_id' => $request->get('province_id'),
        ]);
        $district->save();
        return redirect('/district')->with('success', 'district saved!');
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
