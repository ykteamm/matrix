<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Test;
class TestController extends Controller
{
    public function test(){
        $id = Test::all();
        return $id;
    }
}
