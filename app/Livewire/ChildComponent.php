<?php

namespace App\Livewire;

use Livewire\Component;

class ChildComponent extends Component
{
    public function notifyParent()
    {
        $this->dispatch('child-button-clicked', text: 'Bericht ontvangen van kindcomponent!');
    }

    public function render()
    {
        return view('livewire.child-component');
    }
}
