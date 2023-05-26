<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::orderBy('id', "DESC")->get();
        return view('infos.index', compact('infos'));
    }

    public function create()
    {
        return view('infos.create');
    }

    public function edit($id)
    {
        if ($info = Info::find($id)) {
            return view('infos.edit', compact('info'));
        } else {
            return redirect("allinfos")->with("newsError", "Not found");
        }
    }

    public function store(Request $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        try {
            $pathname = null;
            if($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = date("Y-m-d:h:m:s") . $img->getClientOriginalName();
                $destinationPath = public_path() . '/news/imgs';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/imgs/' . $imageName);
                
            }
            Info::create([
                'title' => $title,
                'img' => $pathname,
                'desc' => $desc,
                'publish' => isset($request->publish) ? true : false
            ]);
            return redirect("allinfos");
        } catch (\Throwable $th) {
            return redirect("allinfos")->with("newsError", $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $desc = $request->desc;
        try {
            $new = Info::find($id);
            $pathname = null;
            if($request->hasFile('img')) {
                $img = $request->file('img');
                $imageName = date("Y-m-d:h:m:s") . $img->getClientOriginalName();
                $destinationPath = public_path() . '/news/imgs';
                $path = $img->move($destinationPath, $imageName);
                $pathname = asset('news/imgs/' . $imageName);
                Storage::delete($new->img);
            }
            Info::where('id', $id)->update([
                'title' => $title,
                'desc' => $desc,
                'img' => $pathname ?? $new->img,
                'publish' => isset($request->publish) ? true : false
            ]);
            return redirect("allinfos");
        } catch (\Throwable $th) {
            return redirect("allinfos")->with("newsError", $th->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            Info::where('id', $id)->delete();
            return redirect("allinfos");
        } catch (\Throwable $th) {
            return redirect("allinfos")->with("newsError", $th->getMessage());
        }
    }
}
