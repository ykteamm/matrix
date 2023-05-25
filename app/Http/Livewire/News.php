<?php

namespace App\Http\Livewire;

use App\Models\News as ModelsNews;
use App\Models\NewsLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class News extends Component
{
    public $newsIds = [];
    public $nw = null;
    public $like = null;
    public $dislike = null;
    protected $listeners = ['showNw' => 'showNwMethod', 'like' => 'changeLike', 'dislike' => 'changeDislike'];

    public function showNwMethod($id)
    {
        try {
            $this->nw = ModelsNews::find($id);
            $this->like = NewsLike::where('news_id', $this->nw->id)
            ->where('user_id', Auth::id())
            ->where('positive', true)
            ->first();
            $this->dislike = NewsLike::where('news_id', $this->nw->id)
            ->where('user_id', Auth::id())
            ->where('positive', false)
            ->first();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function changeLike()
    {
        try {
            if ($this->like) {
                $this->delete('like', true);
            } else {
                if ($this->dislike) {
                    $this->delete('dislike', false);
                }
                $this->like = $this->create('like', true);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function changeDislike()
    {
        try {
            if ($this->dislike) {
                $this->delete('dislike', false);
            } else {
                if ($this->like) {
                    $this->delete('like', true);
                }
                $this->dislike = $this->create('dislike', false);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function delete($like, $positive)
    {
        NewsLike::where('news_id', $this->nw->id)
            ->where('user_id', Auth::id())
            ->where('positive', $positive)
            ->delete();
        $this->nw->{$like} = $this->nw->{$like} - 1;
        $this->nw->save();
        $this->{$like} = null;
    }

    private function create($like, $positive)
    {
        $this->nw->{$like} = $this->nw->{$like} + 1;
        $this->nw->save();
        return NewsLike::create([
            'user_id' => Auth::id(),
            'news_id' => $this->nw->id,
            'positive' => $positive
        ]);
    }

    public function mount()
    {
        $this->newsIds = ModelsNews::orderBy('id', "DESC")->pluck('id');
    }

    public function render()
    {
        return view('livewire.news');
    }
}
