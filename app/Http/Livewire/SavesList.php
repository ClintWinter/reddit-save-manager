<?php

namespace App\Http\Livewire;

use App\Save;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SavesList extends Component
{
    use WithPagination;

    public $perPage = 15;

    public $listeners = [
        'setPerPage' => 'setPerPage',
    ];

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function render()
    {
        return view('livewire.saves-list', [
            'saves' => Auth::user()->saves()->orderBy('created_at')->paginate($this->perPage),
        ]);
    }
}
