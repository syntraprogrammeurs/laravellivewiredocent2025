<?php

namespace App\Livewire;

use Livewire\Component;

class DomEventExample extends Component
{
    // Methode wordt geactiveerd via de knop in de Blade-view
    public function triggerFocus()
    {
        // Zend een DOM-event naar de browser
        $this->dispatch('focus-input');
    }

    public function render()
    {
        return view('livewire.dom-event-example');
    }
}

