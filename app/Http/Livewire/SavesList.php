<?php

namespace App\Http\Livewire;

use App\Save;
use Livewire\Component;
use Livewire\WithPagination;

class SavesList extends Component
{
    use WithPagination;

    public $saves;

    public $user;

    public function mount()
    {
        $this->saves = $this->user->saves()->orderBy('created_at')->get();
    }

    public function render()
    {
        return view('livewire.saves-list');
    }
}
