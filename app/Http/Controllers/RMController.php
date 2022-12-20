<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RmService;
use App\Models\Region;

class RMController extends Controller
{
    public $service;
    public function __construct(RmService $service)
    {
        $this->service=$service;
    }
    public function index()
    {
        
        if(intval(date('h',strtotime(date_now()))) >= 0 && intval(date('h',strtotime(date_now()))) <= 13) 
        {
            $users = $this->service->users();
            $pharmacy = $this->service->pharmacy();
            $medicine = $this->service->medicine();
            return view('rm.index',compact('users','pharmacy','medicine'));
        }else{
            return view('rm.live',compact('users','pharmacy','medicine'));
        }
    }
    public function region()
    {
        return view('rm.region');
    }
    public function user()
    {
        return view('rm.user');
    }
    public function pharmacy()
    {
        return view('rm.pharmacy');
    }
    public function medicine()
    {
        return view('rm.medicine');
    }
}
