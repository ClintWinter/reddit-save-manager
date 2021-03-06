<?php

namespace App\Http\Livewire;

use App\Subreddit;
use Livewire\Component;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use App\Saves\Actions\SyncSavesAction;
use App\Services\RedditService;

class Saves extends Component
{
    public $data;

    public $search = '';

    public $filters = [
        'type' => '',
        'subreddit' => '',
    ];

    public $savePipeline = [
        \App\Pipes\Saves\Filter::class,
        \App\Pipes\Saves\Search::class,
        \App\Pipes\Saves\Order::class,
        \App\Pipes\Saves\Paginate::class,
    ];

    public function getPerPageProperty()
    {
        return session('perPage', 15);
    }

    public function updatePerPage($count)
    {
        if (! in_array($count, [15, 25, 50])) {
            return;
        }

        session(['perPage' => $count]);
    }

    public function syncSaves(RedditService $redditService)
    {
        $redditService->syncSaves(Auth::user());
    }

    private function pipeData()
    {
        return [
            'search' => $this->search,
            'perPage' => $this->perPage,
            'filters' => $this->filters,
        ];
    }

    public function render()
    {
        $user = Auth::user();

        $saves = (new Pipeline(app()))
            ->send([$user->saves()->with(['subreddit', 'tags', 'type']), $this->pipeData()])
            ->through($this->savePipeline)
            ->then(function ($data) { return $data[0]; });

        return view('livewire.saves', [
            'user' => $user,
            'saves' => $saves,
            'subreddits' => $user->getSubredditsWithCount(),
        ]);
    }
}
