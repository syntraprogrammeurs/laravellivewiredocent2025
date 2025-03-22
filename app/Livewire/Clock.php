<?php

namespace App\Livewire;

use Livewire\Component;

class Clock extends Component
{
    public function render()
    {
        return view('livewire.clock', [
            'now' => now()->format('H:i:s'),
        ]);
    }
}
