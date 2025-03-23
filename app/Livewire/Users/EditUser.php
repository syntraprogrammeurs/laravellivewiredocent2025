<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditUser extends Component
{
    public User $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $this->user->update([
                'password' => Hash::make($this->password)
            ]);
        }

        session()->flash('message', 'Gebruiker succesvol bijgewerkt.');
        session()->flash('message_type', 'success');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit-user');
    }
} 