<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class AjaxController extends Controller
{
    public function getBranch(Request $request)
    {
        $branchs = Branch::where('hospital_id',$request->hospital_id)->get();
        return [
            'branchs' => $branchs,
        ];  
    }
}
