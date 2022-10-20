<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shablon;
use App\Models\AllProduct;
use Illuminate\Support\Facades\DB;

class ShablonController extends Controller
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
        $shablons = Shablon::with('medicine')->orderBy('id')->get();
        return view('shablon.create',compact('shablons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new Shablon([
            'name' => $request->name,
        ]);
        $new->save();
        if($new->id)
        {
            return redirect()->back();
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
    public function priceMed($id)
    {
        $products = AllProduct::all();
        return view('shablon.price',compact('id','products'));
    }
    public function priceMedStore(Request $request)
    { 
        $inputs = $request->all();
        $shablon_id = $inputs['shablon_id'];
        unset($inputs['_token']);
        unset($inputs['shablon_id']);
        $i=1;
        foreach($inputs as $key => $value)
        {
            $name = AllProduct::find($key);
            $new = DB::table('tg_medicine')->insert([
                'name' => $name->name,
                'code' => 'P0'.$i,
                'price' => $value,
                'sort' => $i,
                'created_at' => date_now(),
                'old_price' => 0,
                'shablon_id' => $shablon_id,
                'category_id' => $name->category_id
            ]);
            $i++;
        }
        $shablons = Shablon::with('medicine')->orderBy('id')->get();
        return view('shablon.create',compact('shablons'));
    }

    public function shablonActive($id)
    {

        $update = Shablon::where('id','>=',1)->update([
            'active' => FALSE,
        ]);
        // return $id;
        
        $update2 = Shablon::where('id',$id)->update([
            'active' => TRUE,
        ]);
        
        return redirect()->back();

    }

    
}
