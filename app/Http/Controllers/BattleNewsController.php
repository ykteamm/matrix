<?php

namespace App\Http\Controllers;

use App\Models\SpecialBattleNews;
use App\Models\AllBattleNews;
use App\Models\NewsImages;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BattleNewsController extends Controller
{
    public function index()
    {
        $news = SpecialBattleNews::orderBy('id', "DESC")->get();
        return view('news.index', compact('news'));
    }
    public function create()
    {
        return view('news.create');
    }
    public function show($id)
    {
        if ($nw = SpecialBattleNews::find($id)) {
            return view('news.show', compact('nw'));
        } else {
            return redirect("/battlenews")->with("newsError", "Not found");
        }
    }
    public function edit($id)
    {
        if ($nw = SpecialBattleNews::find($id)) {
            return view('news.edit', compact('nw'));
        } else {
            return redirect("/battlenews")->with("newsError", "Not found");
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
        $body = $request->body;
        try {
            $battleN = SpecialBattleNews::create([
                'title' => $title ?? "Sarlavha",
                'body' => $body ?? "Matn"
            ]);
            AllBattleNews::create([
                'title' => $title ?? "Sarlavha",
                'status' => 'special',
                'info' => json_encode([
                    'newsId' => $battleN->id
                ])
            ]);
            return redirect("/battlenews");
        } catch (\Throwable $th) {
            return redirect("/battlenews")->with("newsError", $th->getMessage());
        }
    }

    public function update(Request $request, $spNewsId)
    {
        $title = $request->title;
        $body = $request->body;
        try {
            SpecialBattleNews::where('id', $spNewsId)->update([
                'title' => $title ?? "Sarlavha",
                'body' => $body ?? "Matn"
            ]);
            AllBattleNews::where('info->newsId', $spNewsId)->update([
                'title' => $title ?? "Sarlavha"
            ]);
            return redirect("/battlenews");
        } catch (\Throwable $th) {
            return redirect("/battlenews")->with("newsError", $th->getMessage());
        }
    }
    public function delete($spNewsId)
    {
        try {
            SpecialBattleNews::where('id', $spNewsId)->delete();
            AllBattleNews::where('info->newsId', $spNewsId)->delete();
            return redirect("/battlenews");
        } catch (\Throwable $th) {
            return redirect("/battlenews")->with("newsError", $th->getMessage());
        }
    }
}
