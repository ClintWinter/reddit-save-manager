<?php

namespace App\Http\Livewire;

use App\Save;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Saves\Actions\SyncSavesAction;

class ShowSave extends Component
{
    public Save $save;

    public function syncSaves()
    {
        (new SyncSavesAction)(Auth::user());
    }

    public function render()
    {
        return view('livewire.show-save', [
            'user' => Auth::user(),
        ]);
    }
}
