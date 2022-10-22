<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductJournal;
use App\Models\ProductCategory;
use App\Models\Warehouse;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
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
        $products = Product::with('warehouse','category')->orderBy('id','ASC')
        ->where('delete',TRUE)
        ->get();
        $deletes = Product::with('warehouse','category')->orderBy('id','ASC')
        ->where('delete',FALSE)
        ->get();
        $categories = ProductCategory::all();
        $warehouses = Warehouse::all();
        return view('zavod.product.create',compact('categories','warehouses','products','deletes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $inputs = $request->all();

        $new = new Product($inputs);
        $new->save();
        if($new->id)
        {
            return redirect()->back()->with('message',(__('message.save_success')));
        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

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
        $update = Product::find($id)->delete();
        if($update)
        {
            return redirect()->back()->with('message',(__('message.save_success')));
        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

        }
    }
    public function restore($id)
    {
        $update = Product::where('id',$id)->update([
            'delete' => TRUE
        ]);
        if($update)
        {
            return redirect()->back()->with('message',(__('message.save_success')));
        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

        }
    }

    public function trash($id)
    {
        $update = Product::where('id',$id)->update([
            'delete' => FALSE
        ]);
        if($update)
        {
            return redirect()->back()->with('message',(__('message.save_success')));
        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

        }
    }

    public function productPlus(Request $request,$id)
    {
        $amout = Product::find($id);
        $update = Product::where('id',$id)->update([
            'amount' => intval($amout->amount) + intval($request->plus)
        ]);

        if($update)
        {   
            $journal = new ProductJournal([
                'user_id' => Session::get('user')->id,
                'product_id' => $id,
                'old' => $amout->amount,
                'new' => $request->plus,
                'action' => 1
            ]);

            $journal->save();

            if($journal->id)
            {
                return redirect()->back()->with('message',(__('message.save_success')));
            }

        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

        }
    }

    public function productMinus(Request $request,$id)
    {
        $amout = Product::find($id);
        $update = Product::where('id',$id)->update([
            'amount' => intval($amout->amount) - intval($request->plus)
        ]);

        if($update)
        {   
            $journal = new ProductJournal([
                'user_id' => Session::get('user')->id,
                'product_id' => $id,
                'old' => $amout->amount,
                'new' => $request->plus,
                'action' => 2
            ]);

            $journal->save();

            if($journal->id)
            {
                return redirect()->back()->with('message',(__('message.save_success')));
            }

        }else{
            return redirect()->back()->with('error',(__('message.save_error')));

        }
    }
    public function productJournal()
    {
        $journals = ProductJournal::with('product','user')->orderBy('id','DESC')->get();
        return view('zavod.journal',compact('journals'));
    }

    

}
