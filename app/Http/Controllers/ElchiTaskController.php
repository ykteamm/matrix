<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ElchiTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $user_id=Session::get('user')->id;
//        dd($user_id);
//        dd($request->all());
        $response = Http::post('http://128.199.2.165:8100/api/v1/task/create/', [
            'admin' => $user_id,
            'elchi' => $request['id'],
            'finish_day' => $request['date'],
            'message' => $request['task']
        ]);

        return redirect()->route('elchi',['id'=>$request['id'],'time'=>'today']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
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
     *
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        //
    }
}
