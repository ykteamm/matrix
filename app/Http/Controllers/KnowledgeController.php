<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knowledge;
class KnowledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $knowledges = Knowledge::all();
        return view('knowledge.create',compact('knowledges'));
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
            'knowledge'=>'required',
        ]);

        $data = $request->all();
        $new_knowledge = new Knowledge([
            'name' => $data['knowledge'],
            'created_at' => date_now(),
        ]);
        $new_knowledge->save();
        if($new_knowledge->id)
        {
            return redirect()->back()->with('success','Ma\'lumot saqlandi');
        }else{
            return redirect()->back()->error('error', 'Ma\'lumot saqlanmadi');
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
        $knowledge = Knowledge::find($id);
        return view('knowledge.edit',compact('knowledge'));
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
        $request->validate([
            'knowledge'=>'required',
        ]);
        $data = $request->all();
        $update_knowledge = Knowledge::where('id',$id)->update([
            'name' => $data['knowledge'],
            'updated_at' => date_now(),
        ]);

        if($update_knowledge)
        {
            return redirect()->route('knowledge.create')->with('success','Ma\'lumot saqlandi');
        }else{
            return redirect()->back()->error('error', 'Ma\'lumot saqlanmadi');
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
        $delete = Knowledge::find($id)->delete();
        if($delete){
            return redirect()->back()->with('message',(__('message.delete_success')));
        }else{
            return redirect()->back()->with('message',(__('message.delete_error')));
        }
    }
}
