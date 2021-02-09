<?php

namespace App\Http\Livewire;

use App\Subreddit;
use Livewire\Component;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use App\Saves\Actions\SyncSavesAction;

class Saves extends Component
{
    public $data;

    public $search = '';

    public $filters = [
        'type' => '',
        'subreddit' => '',
    ];

    public $savePipeline = [
        \App\Saves\Pipes\Filter::class,
        \App\Saves\Pipes\Search::class,
        \App\Saves\Pipes\Order::class,
        \App\Saves\Pipes\Paginate::class,
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

    public function syncSaves()
    {
        (new SyncSavesAction)(Auth::user());
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
