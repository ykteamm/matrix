<?php

namespace App\Http\Controllers;

use App\Models\MarketSlider;
use App\Models\MarketSliderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MarketController extends Controller
{
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
