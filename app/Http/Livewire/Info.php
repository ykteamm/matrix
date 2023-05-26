<?php

namespace App\Http\Livewire;

use App\Models\Info as ModelsInfo;
use Livewire\Component;

class Info extends Component
{
    public $infoIds = [];
    public $info = null;
    protected $listeners = ['showInfo' => 'showInfoMethod'];

    public function showInfoMethod($id)
    {
        try {
            $this->info = ModelsInfo::find($id);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function mount()
    {
        $this->infoIds = ModelsInfo::orderBy('id', "DESC")->pluck('id');
    }

    public function render()
    {
        return view('livewire.info');
    }
}
