<?php

namespace App\Http\Livewire;

use App\Models\Video as ModelsVideo;
use Livewire\Component;

class Video extends Component
{
    public $videoIds = [];
    public $video = null;
    protected $listeners = ['showVid' => 'showVideoMethod'];

    public function showVideoMethod($id)
    {
        try {
            $this->video = ModelsVideo::find($id);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function mount()
    {
        $this->videoIds = ModelsVideo::orderBy('id', "DESC")->pluck('id');
    }
    public function render()
    {
        return view('livewire.video');
    }
}
