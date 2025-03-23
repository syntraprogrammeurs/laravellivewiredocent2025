<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ShowRoles extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.roles.show-roles', [
            'roles' => Role::query()
                ->withCount('users')
                ->paginate(10)
        ]);
    }
}
