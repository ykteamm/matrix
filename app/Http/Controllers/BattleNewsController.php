<?php

namespace App\Http\Controllers;

use App\Models\BattleNews;
use App\Models\NewsImages;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BattleNewsController extends Controller
{
    public function index()
    {
        $allNews = DB::table('my_battle_news')->get();
        return view('news.index', compact('allNews'));
    }
    public function create()
    {
        return view('news.create');
    }
    public function show($id)
    {
        $nw = BattleNews::find($id);
        return view('news.show', compact('nw'));
    }
    public function uploadImages(Request $request)
    {
        $images = [];
        $files = $request->file();
        try {
            foreach ($files as $key => $img) {
                $imageName = $img->getClientOriginalName();
                $destinationPath = public_path().'/news' ;
                $path = $img->move($destinationPath, $imageName);
                
                NewsImages::create([
                    'imgname' => $imageName,
                    'imgpath' => $path
                ]);
                $images[] = asset('news/'.$imageName);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
        return response()->json(compact('images'));
    }
    public function store(Request $request)
    {
        $title = $request->title;
        $body = $request->body;
        $battleN = BattleNews::create([
            'title' => $title ?? "Sarlavha",
            'body' => $body ?? "Matn"
        ]);
        DB::table('my_battle_news')->insert([
            'title' => $title ?? "Sarlavha",
            'status' => 'special',
            'info' => json_encode([
                'newsId' => $battleN->id
            ])
        ]);
        return redirect()->back();
    }
}
