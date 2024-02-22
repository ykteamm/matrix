<?php

namespace App\Http\Controllers;

use App\Models\Topshiriq;
use App\Models\TopshiriqLevel;
use Illuminate\Http\Request;

class TopshiriqController extends Controller
{
    public function index()
    {
        $topshiriq = Topshiriq::orderBy('id','asc')->where('status',1)->get();

        return view('topshiriq.index',compact('topshiriq'));
    }

    public function level()
    {
        $level= TopshiriqLevel::orderBy('id','asc')->get();

        return view('topshiriq.level',compact('level'));

    }

    public function create(Request $request)
    {
        $topshiriq = new Topshiriq();
        $topshiriq->name = $request->name;
        $topshiriq->description = $request->description;
        $topshiriq->first_date = $request->first_date;
        $topshiriq->end_date = $request->end_date;
        $topshiriq->number = $request->number;
        $topshiriq->star = $request->star;
        $topshiriq->crystall = $request->crystall;
        $topshiriq->key = $request->key;
        if (!$topshiriq->save()){
            return redirect(route('topshiriq-index'))->with('error','Xatolik bor!');
        }
        return redirect(route('topshiriq-index'))->with('success','Topshiriq muvaffaqiyatli qo\'shildi!');
    }

    public function update(Request $request, $id)
    {
        $topshiriq = Topshiriq::find($id);
        $topshiriq->name = $request->name;
        $topshiriq->description = $request->description;
        $topshiriq->first_date = $request->first_date;
        $topshiriq->end_date = $request->end_date;
        $topshiriq->number = $request->number;
        $topshiriq->star = $request->star;
        $topshiriq->crystall = $request->crystall;
        $topshiriq->key = $request->key;
        $topshiriq->status = $request->status;
        if (!$topshiriq->save()){
            return redirect(route('topshiriq-index'))->with('error','Xatolik bor!');
        }
        return redirect(route('topshiriq-index'))->with('success','Topshiriq muvaffaqiyatli tahrirlandi');
    }


    public function LevelCreate(Request $request)
    {
        $level = new TopshiriqLevel();
        $level->daraja = $request->daraja;
        $level->name = $request->name;
        $level->number_star = $request->number_star;

        if (!$level->save()){
            return redirect(route('topshiriq-level'))->with('error','Xatolik bor!');
        }
        return redirect(route('topshiriq-level'))->with('success','Daraja muvaffaqiyatli qo\'shildi!');
    }

    public function LevelUpdate(Request $request, $id)
    {
        $level_id = TopshiriqLevel::find($id);
        $level_id->daraja = $request->daraja;
        $level_id->name = $request->name;
        $level_id->number_star = $request->number_star;

        if (!$level_id->save()){
            return redirect(route('topshiriq-level'))->with('error','Xatolik bor!');
        }
        return redirect(route('topshiriq-level'))->with('success','Daraja muvaffaqiyatli tahrirlandi');
    }
}
