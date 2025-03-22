<?php

// 📁 app/Livewire/Users/ShowUsers.php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Gebruikersbeheer')]
class ShowUsers extends Component
{
    public function render()
    {
        return view('livewire.users.show-users', [
            'users' => User::latest()->get(), // Alle gebruikers ophalen, meest recent eerst
        ]);
    }
}

