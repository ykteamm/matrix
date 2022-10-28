<?php

namespace App\Http\Controllers;

use App\Services\ElchilarService;
use Illuminate\Http\Request;

class ElchilarController extends Controller
{
    public $service;
    public function __construct(ElchilarService $service)
    {
        $this->service=$service;
    }

    public function kunlik()
    {
        $data=$this->service->elchilar();
        $elchi=$data->elchi;
        $elchi_work=$data->elchi_work;
        $elchi_fact=$data->elchi_fact;
        $elchi_prognoz=$data->elchi_prognoz;
        $plan=$this->service->plan($elchi);
        $plan_day=$this->service->planday($elchi);
        $encane=$this->service->encane($elchi);
        $days=$this->service->checkCalendar();
        $sold=$this->service->sold($elchi,$days);

        return view('elchilar.index',compact('elchi_prognoz','elchi','elchi_work','elchi_fact','plan','plan_day','encane','days','sold'));
    }
}
