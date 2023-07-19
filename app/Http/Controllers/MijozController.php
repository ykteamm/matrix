<?php

namespace App\Http\Controllers;

use App\Models\MijozBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
class MijozController extends Controller
{
    public function banner()
    {
        $banner = MijozBanner::first();

        return view('mijoz.index',compact('banner'));
    }

    public function bannerSave(Request $request)
    {
        
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/mijoz/banner';
        $file->move($destinationPath,$fileName);
        
        MijozBanner::create([
            'text' => $request->text,
            'image' => $fileName
        ]);


        return redirect()->back();
    }

    public function bannerUpdate(Request $request,$banner_id)
    {
        
        
        $file = $request->file('image') ;
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path().'/mijoz/banner';
        $file->move($destinationPath,$fileName);
        

        $banner = MijozBanner::find($banner_id);
        $image_path = app_path("mijoz/banner/{$banner->image}");
        if (File::exists($image_path)) {
            unlink($image_path);
        }

        $banner->text = $request->text;
        $banner->image = $fileName;
        $banner->save();

        

        
        return redirect()->back();
    }
}
