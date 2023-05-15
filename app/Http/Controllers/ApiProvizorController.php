<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class ApiProvizorController extends Controller
{
    public function getRegionDistrict()
    {
        $region = Region::all();
        return $region;
    }
}
