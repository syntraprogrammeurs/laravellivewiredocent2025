<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SearchResults extends Component
{
    public string $query = '';

    // ⬅️ Luistert naar het event dat werd uitgezonden
    #[On('search-updated')]
    public function updateResults(string $query)
    {
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.search-results');
    }
}

