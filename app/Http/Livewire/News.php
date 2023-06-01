<?php

namespace App\Http\Livewire;

use App\Models\News as ModelsNews;
use App\Models\NewsEmoji;
use App\Models\NewsLike;
use App\Models\NewsReaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class News extends Component
{
    public $newsIds = [];
    public $nw = null;
    public $reaction = null;
    public $emojies = [];
    protected $listeners = ['showNw' => 'showNwMethod', 'reaction' => 'setReaction'];

    public function mount()
    {
        $this->newsIds = ModelsNews::orderBy('id', "DESC")->pluck('id');
    }

    public function showNwMethod($id)
    {
        try {
            $this->nw = ModelsNews::find($id);
            $this->emojies = $this->getEmojies($id);
            $this->reaction = NewsReaction::where('user_id', Auth::id())
                ->where('news_id', $this->nw->id)
                ->first();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function setReaction($emojiId)
    {
        $emoji = NewsEmoji::find($emojiId);
        if ($this->reaction) {
            NewsReaction::where('user_id', Auth::id())
                ->where('news_id', $this->nw->id)
                ->where('emoji_id', $this->reaction->emoji_id)
                ->delete();
            if ($this->reaction->emoji_id == $emojiId) {
                $this->reaction = null;
            } else {
                $this->reaction = NewsReaction::create([
                    'user_id' => Auth::id(),
                    'news_id' => $this->nw->id,
                    'emoji_id' => $emoji->id
                ]);
            }
            $this->emojies = $this->getEmojies($this->nw->id);
        } else {
            $this->reaction = NewsReaction::create([
                'user_id' => Auth::id(),
                'news_id' => $this->nw->id,
                'emoji_id' => $emoji->id
            ]);
            $this->emojies = $this->getEmojies($this->nw->id);
        }
    }

    public function getEmojies($id)
    {
        return DB::table('news_emojies AS ne')
            ->select('ne.icon', 'ne.id', DB::raw("sum(case when nw.id = $id then 1 else 0 end) as count"))
            ->leftJoin('news_reactions AS nr', 'nr.emoji_id', 'ne.id')
            ->leftJoin('news AS nw', 'nw.id', 'nr.news_id')
            ->groupBy('ne.id')
            ->orderBy('ne.id', "ASC")
            ->get();
    }

    public function render()
    {
        return view('livewire.news');
    }
}
