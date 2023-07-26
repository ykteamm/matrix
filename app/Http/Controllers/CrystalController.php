<?php

namespace App\Http\Controllers;

use App\Models\CrystalUser;
use App\Models\User;
use Illuminate\Http\Request;

class CrystalController extends Controller
{
    public function addCrystal()
    {
        $users = User::all();

        return view('crystal.index',[
            'users' => $users
        ]);
    }

    public function saveCrystal(Request $request)
    {
        $inputs = $request->all();

        CrystalUser::create([
            'user_id' => $inputs['user_id'],
            'crystal' => $inputs['crystal'],
            'comment' => $inputs['comment'],
            'active' => 1,
            'add_date' => date('Y-m-d'),
        ]);

        return redirect()->back();
    }
}
