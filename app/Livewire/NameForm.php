<?php

namespace App\Livewire;

use App\Http\Requests\NameFormRequest;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class NameForm extends Component
{
    // Dynamische properties die automatisch gebonden zijn aan de inputvelden
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';

    /**
     * Lifecycle hook: Wordt automatisch aangeroepen als één van de properties verandert.
     * Hierdoor kunnen we veld-per-veld valideren.
     */
    public function updated($property): void
    {
        Validator::make(
            [$property => $this->$property],
            (new NameFormRequest())->rules(),
            (new NameFormRequest())->messages()
        )->validate();
    }

    /**
     * Wordt uitgevoerd bij klikken op de verzendknop.
     * Voert volledige validatie uit.
     */
    public function submit(): void
    {
        $this->validate(
            (new NameFormRequest())->rules(),
            (new NameFormRequest())->messages()
        );

        session()->flash('success', 'Formulier succesvol verzonden!');
    }

    /**
     * Reset alle properties én foutmeldingen.
     * LET OP: reset() is een ingebouwde Livewire-methode.
     * - reset(['property1', 'property2', ...]) zet waarden van die properties terug naar hun default.
     * - resetErrorBag() wist de foutmeldingen (anders blijven oude errors zichtbaar).
     */
    public function resetForm(): void
    {
        $this->reset(['firstName', 'lastName', 'email']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.name-form');
    }
}
