<?php

namespace App\Livewire;

use Livewire\Component;

class SearchInput extends Component
{
    public string $query = '';

    public function updatedQuery()
    {
        // 🛰️ Verstuur de zoekterm naar de resultatencomponent
        $this->dispatch('search-updated', query: $this->query);
    }

    public function render()
    {
        return view('livewire.search-input');
    }
}

