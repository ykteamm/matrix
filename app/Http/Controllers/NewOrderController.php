<?php

namespace App\Http\Controllers;

use App\Http\Livewire\McMoney;



class NewOrderController extends Controller
{
    public function index()
    {
        return view('new-order.index');
    }
    
}
