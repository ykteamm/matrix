<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', "DESC")->get();
        return view('news.index', compact('news'));
    }
    public function create()
    {
        return view('news.create');
    }
    public function show($id)
    {
        if ($nw = News::find($id)) {
            return view('news.show', compact('nw'));
        } else {
            return redirect("allnews")->with("newsError", "Not found");
        }
    }
    public function edit($id)
    {
        if ($nw = News::find($id)) {
            return view('news.edit', compact('nw'));
        } else {
            return redirect("allnews")->with("newsError", "Not found");
        }
    }
    public function uploadImages(Request $request)
    {
        $images = [];
        $files = $request->file();
        try {
            foreach ($files as $key => $img) {
                $imageName = $img->getClientOriginalName();
                $destinationPath = public_path() . '/news';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/' . $imageName);
                if($img = NewsImages::where('imgpath', $pathname)->first()) {
                    $images[] = $img;
                    continue;
                }
                $image = NewsImages::create([
                    'imgname' => $imageName,
                    'imgpath' => $pathname
                ]);
                $images[] = $image;
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
        return response()->json(compact('images'));
    }

    public function uploadedImages()
    {
        $images = NewsImages::all();
        return response()->json(compact('images')); 
    }
    
    public function store(Request $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        try {
            $pathname = null;
            if($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = $img->getClientOriginalName();
                $info = getimagesize($img);
                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($img);
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($img);

                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($img);
                    
                elseif ($info['mime'] == 'image/webp') 
                    $image = imagecreatefromwebp($img);

                // $destinationPath = public_path() . '/news/imgs/' . $imageName;
                // imagejpeg($image, $destinationPath, 30);
                // imagepng($image, $destinationPath, 80);
                // $pathname = asset('news/imgs/' . $imageName);
                $imageName = $img->getClientOriginalName();
                $destinationPath = public_path() . '/news/imgs';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/imgs' . $imageName);
                
            }
            News::create([
                'title' => $title,
                'img' => $pathname,
                'desc' => $desc
            ]);
            return redirect("allnews");
        } catch (\Throwable $th) {
            return redirect("allnews")->with("newsError", $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $desc = $request->desc;
        try {
            $new = News::find($id);
            $pathname = null;
            if($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = $img->getClientOriginalName();
                $info = getimagesize($img);
                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($img);
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($img);

                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($img);
                    
                elseif ($info['mime'] == 'image/webp') 
                    $image = imagecreatefromwebp($img);

                $destinationPath = public_path() . '/news/imgs/' . $imageName;
                imagejpeg($image, $destinationPath, 30);
                $pathname = asset('news/imgs/' . $imageName);
                Storage::delete($new->img);
            }
            News::where('id', $id)->update([
                'title' => $title,
                'desc' => $desc,
                'img' => $pathname ?? $new->img
            ]);
            return redirect("allnews");
        } catch (\Throwable $th) {
            return redirect("allnews")->with("newsError", $th->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            News::where('id', $id)->delete();
            return redirect("allnews");
        } catch (\Throwable $th) {
            return redirect("allnews")->with("newsError", $th->getMessage());
        }
    }
}
