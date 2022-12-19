<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\RmService;

class Livepharmacy extends Component
{
    public $day;
    public $user;
    public function test()
    {
        $this->day = 7;
        
    }
    public function render()
    {
        $u = new RmService;
        $this->pharmacy = $u->pharmacy();
        return view('livewire.livepharmacy');
    }
}
