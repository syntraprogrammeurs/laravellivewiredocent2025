<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'viewer'; // Standaard rol

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'role' => ['required', 'string', 'exists:roles,name'],
    ];

    public function mount()
    {
        // Check of de gebruiker de juiste permissions heeft
        if (!auth()->user()->can('create users')) {
            abort(403);
        }
    }

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Ken de geselecteerde rol toe
        $user->assignRole($this->role);

        session()->flash('message', 'Gebruiker succesvol aangemaakt.');
        session()->flash('message_type', 'success');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.create-user', [
            'roles' => Role::all()
        ]);
    }
}
