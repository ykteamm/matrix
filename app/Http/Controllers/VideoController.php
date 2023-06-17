<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('id', "DESC")->get();
        return view('videos.index', compact('videos'));
    }
    
    public function create()
    {
        return view('videos.create');
    }
   
    public function edit($id)
    {
        if ($video = Video::find($id)) {
            return view('videos.edit', compact('video'));
        } else {
            return redirect("allvideos")->with("newsError", "Not found");
        }
    }

    public function store(Request $request)
    {
        $title = $request->title;
        $url = $request->url;
        $desc = $request->desc;
        $category = $request->category;
        try {
            $pathname = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = date("Y-m-d:h:m:s") . $img->getClientOriginalName();
                $destinationPath = public_path() . '/news/imgs';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/imgs/' . $imageName);
            }
            Video::create([
                'title' => $title,
                'img' => $pathname,
                'desc' => $desc,
                'url' => $url,
                'category' => $category ?? 0,
                'publish' => isset($request->publish) ? true : false
            ]);
            return redirect("allvideos");
        } catch (\Throwable $th) {
            return redirect("allvideos")->with("newsError", $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $desc = $request->desc;
        $url = $request->url;
        $category = $request->category;
        try {
            $video = Video::find($id);
            $pathname = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = date("Y-m-d:h:m:s") . $img->getClientOriginalName();
                $destinationPath = public_path() . '/news/imgs';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/imgs/' . $imageName);
                Storage::delete($video->img);
            }
            Video::where('id', $id)->update([
                'title' => $title,
                'desc' => $desc,
                'img' => $pathname ?? $video->img,
                'url' => $url ?? $video->url,
                'category' => $category ?? 0,
                'publish' => isset($request->publish) ? true : false
            ]);
            return redirect("allvideos");
        } catch (\Throwable $th) {
            return redirect("allvideos")->with("newsError", $th->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            Video::where('id', $id)->delete();
            return redirect("allvideos");
        } catch (\Throwable $th) {
            return redirect("allvideos")->with("newsError", $th->getMessage());
        }
    }
}
