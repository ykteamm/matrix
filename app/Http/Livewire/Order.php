<?php

namespace App\Http\Livewire;

use App\Models\Medicine;
use Livewire\Component;

class Order extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Medicine::all();
    }

    public function render()
    {
        return view('livewire.order');
    }
}
