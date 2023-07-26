<?php

namespace App\Http\Controllers;

use App\Models\MarketSlider;
use App\Models\MarketSliderCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MarketController extends Controller
{

    public function product()
    {
        $products = DB::table('outer_markets')->orderBy('id')->get();
        return view('market.product',compact('products'));
 
    }

    public function productSave(Request $request)
    {
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/outermarket';
        $file->move($destinationPath,$fileName);
        
        DB::table('outer_markets')->insert([
            'name' => $request->name,
            'crystall' => $request->crystall,
            'image' => $fileName,
        ]);


        return redirect()->back();
    }


    public function productUpdate(Request $request,$id)
    {
        if($request->file('image'))
        {
            $file = $request->file('image') ;
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path().'/outermarket';
            $file->move($destinationPath,$fileName);
            

            $banner = DB::table('outer_markets')->where('id',$id)->first();
            if (file_exists(public_path('outermarket/'.$banner->image))){
                unlink(public_path('outermarket/'.$banner->image));
            }

            $banner = DB::table('outer_markets')->where('id',$id)->update([
                'name' => $request->name,
                'crystall' => $request->crystal,
                'image' => $fileName,
            ]);
        }else{
            $banner = DB::table('outer_markets')->where('id',$id)->update([
                'name' => $request->name,
                'crystall' => $request->crystal,
            ]);
        }
        

        return redirect()->back();
    }

    public function productDelete($id)
    {

        $banner = DB::table('outer_markets')->where('id',$id)->first();

        if (file_exists(public_path('outermarket/'.$banner->image))){
            unlink(public_path('outermarket/'.$banner->image));
        }
        
        DB::table('outer_markets')->where('id',$id)->delete();

        return redirect()->back();
    }

    public function category()
    {
        $categories = MarketSliderCategory::all();

        return view('market.category',compact('categories'));
    }

    public function categorySave(Request $request)
    {
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/market/category';
        $file->move($destinationPath,$fileName);
        
        MarketSliderCategory::create([
            'name' => $request->text,
            'image' => $fileName,
            'active' => 1,
        ]);


        return redirect()->back();
    }

    public function categoryUpdate(Request $request,$id)
    {
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/market/category';
        $file->move($destinationPath,$fileName);
        

        $banner = MarketSliderCategory::find($id);
        if (file_exists(public_path('market/category/'.$banner->image))){
            unlink(public_path('market/category/'.$banner->image));
        }

        $banner->name = $request->text;
        $banner->image = $fileName;
        $banner->save();

        return redirect()->back();
    }

    public function categoryDelete($id)
    {

        $banner = MarketSliderCategory::find($id);

        if (file_exists(public_path('market/category/'.$banner->image))){
            unlink(public_path('market/category/'.$banner->image));
        }
        
        MarketSliderCategory::find($id)->delete();

        $sliders = MarketSlider::where('category_id',$id)->get();

        foreach ($sliders as $key => $value) {
            if (file_exists(public_path('market/slider/'.$value->image))){
                unlink(public_path('market/slider/'.$value->image));
            }
        }

        MarketSlider::where('category_id',$id)->delete();

        return redirect()->back();
    }
    public function slider()
    {
        $categories = MarketSliderCategory::all();
        $sliders = MarketSlider::with('category')->get();

        return view('market.slider',compact('categories','sliders'));
    }

    public function sliderSave(Request $request)
    {
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/market/slider';
        $file->move($destinationPath,$fileName);
        
        MarketSlider::create([
            'category_id' => $request->category_id,
            'name' => $request->text,
            'image' => $fileName,
            'active' => 1,
        ]);


        return redirect()->back();
    }

    public function sliderUpdate(Request $request,$id)
    {
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/market/slider';
        $file->move($destinationPath,$fileName);
        

        $banner = MarketSlider::find($id);
        if (file_exists(public_path('market/slider/'.$banner->image))){
            unlink(public_path('market/slider/'.$banner->image));
        }

        $banner->name = $request->text;
        $banner->image = $fileName;
        $banner->save();

        return redirect()->back();
    }

    public function sliderDelete($id)
    {

        $banner = MarketSlider::find($id);

        if (file_exists(public_path('market/slider/'.$banner->image))){
            unlink(public_path('market/slider/'.$banner->image));
        }
        
        MarketSlider::find($id)->delete();

        return redirect()->back();
    }
}
