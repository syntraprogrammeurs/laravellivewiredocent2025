<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public string $title;

    /**
     * Creëert een nieuwe kaartcomponent met een titel
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.card');
    }
}
