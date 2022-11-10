<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shablon;
use App\Models\AllProduct;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\ShablonPharmacy;
use App\Models\Price;
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
        // $asd = DB::table('tg_medicine')->where('id','<',61)->get();
        // $ary = [];
        // foreach($asd as $key => $a)
        // {
        //     $ids = ($a->id)+60;
        //     $up = DB::table('tg_productssold')
        //     ->where('id','>',13487)
        //     ->where('medicine_id',$a->id+60)
        //     ->update([
        //         'medicine_id' => $a->id,
        //         'price_product' => $a->price,
        //     ]);
        // }
        // return $up;
        $shablons = Shablon::with('price')->orderBy('id')->get();
        // return $shablons;
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
        // $medicine = Medicine::all();
        // foreach($medicine as $med)
        // {
        //     $new = new AllProduct([
        //         'name' => $med->name,
        //         'category_id' => $med->category_id,   
        //     ]);
        //     $new->save();
        // }
        // return $medicine;
        $products = Medicine::orderBy('id')->get();
        return view('shablon.price',compact('id','products'));
    }
    public function priceMedStore(Request $request)
    { 
        $inputs = $request->all();
        $shablon_id = $inputs['shablon_id'];
        unset($inputs['_token']);
        unset($inputs['shablon_id']);
        foreach($inputs as $key => $value)
        {
            $new = new Price([
                'price' => $value,
                'medicine_id' => $key,
                'shablon_id' => $shablon_id,
            ]);
            $new->save();
        }
        return redirect()->route('shablon.create');
    }
    public function priceMedUpdate(Request $request,$id)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $new = Shablon::where('id',$id)->update([
            'name' => $inputs['shablon_name'],
        ]);
        unset($inputs['shablon_name']);

        foreach($inputs as $key => $value)
        {
            $new = Price::where('shablon_id',$id)->where('medicine_id',$key)->update([
                'price' => $value,
            ]);
        }
        return redirect()->route('shablon.create');

    }
    public function priceMedEdit($id)
    {
        $medicines = Price::with('medicine')->where('shablon_id',$id)->orderBy('id')->get();    
        $shablon = Shablon::find($id);
        return view('shablon.price-edit',compact('medicines','shablon'));

    }
    public function shablonActive(Request $request,$id)
    {
        // return $id;
        $update = Shablon::where('id','>=',1)->update([
            'active' => FALSE,
        ]);
        // return $id;
        
        $update2 = Shablon::where('id',$id)->update([
            'active' => TRUE,
        ]);
        
        return redirect()->back();

    }

    public function shablonPharmacy()
    {
        $pharmacies = Pharmacy::all();
        $shablons = Shablon::with('shablon_pharmacy')->get();
        return view('shablon.pharmacy',compact('pharmacies','shablons'));
    }

    public function shablonPharmacyStore(Request $request)
    {
        $request->validate([
            'shablon_id'=>'required',
            'pharmacy_id'=>'required'
         ]);
         $r=$request->all();
         unset($r['_token']);
         $id=$r['shablon_id'];
         foreach ($r['pharmacy_id'] as $item){
             $p=new ShablonPharmacy();
             $p->shablon_id=$id;
             $p->pharmacy_id=$item;
             $p->save();
         }
         return redirect()->back();
    }
    public function shablonPharmacyEdit($id)
    {
        $shablons = Shablon::all();
        $pharmacies = Pharmacy::all();
        $shablon = Shablon::with('shablon_pharmacy')->where('id',$id)->first();
        $inarray=[];
        foreach($shablon->shablon_pharmacy as $item)
        {
            $inarray[] = $item->pharmacy_id;
        }
        return view('shablon.pharmacy-edit',compact('shablons','shablon','pharmacies','inarray'));

    }
    public function shablonPharmacyUpdate(Request $request,$id)
    {
        $request->validate([
            'shablon_id'=>'required',
            'pharmacy_id'=>'required'
         ]);
         $r=$request->all();
         unset($r['_token']);
         $id=$r['shablon_id'];
         $del = ShablonPharmacy::where('shablon_id',$id)->delete();
         foreach ($r['pharmacy_id'] as $item){
             $p=new ShablonPharmacy();
             $p->shablon_id=$id;
             $p->pharmacy_id=$item;
             $p->save();
         }
         return redirect()->route('shablon.pharmacy');
    }
}
