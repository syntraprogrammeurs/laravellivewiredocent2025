<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0;
    public int $min = 0;
    public int $max = 10;

    public function increment()
    {
        if ($this->count < $this->max) {
            $this->count++;
        }
    }

    public function decrement()
    {
        if ($this->count > $this->min) {
            $this->count--;
        }
    }

    public function resetCount()
    {
        $this->count = 0;
    }


    public function render()
    {
        return view('livewire.counter');
    }
}
