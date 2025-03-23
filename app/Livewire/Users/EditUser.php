<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public User $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? 'viewer';
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
        ];
    }

    public function update()
    {
        // Check of de gebruiker de juiste permissions heeft
        if (!auth()->user()->can('edit users')) {
            abort(403);
        }

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

        // Update de rol
        $this->user->syncRoles([$this->role]);

        session()->flash('message', 'Gebruiker succesvol bijgewerkt.');
        session()->flash('message_type', 'success');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit-user', [
            'roles' => Role::all()
        ]);
    }
} 