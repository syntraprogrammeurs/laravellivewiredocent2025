<?php

// 📁 app/Livewire/Users/ShowUsers.php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

#[Title('Gebruikersbeheer')]
class ShowUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showDeleted = false;
    public $message = '';
    public $showMessage = false;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedUsers = [];
    public $selectAll = false;
    public $editingUserId = null;
    public $editingName = '';
    public $editingEmail = '';
    public $editingPassword = '';
    public $editingPasswordConfirmation = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete(User $user)
    {
        if (!auth()->user()->can('delete users')) {
            abort(403);
        }
        $user->delete();
        session()->flash('message', 'Gebruiker verwijderd.');
        session()->flash('message_type', 'error');
    }

    public function forceDelete($userId)
    {
        if (!auth()->user()->can('force delete users')) {
            abort(403);
        }
        User::withTrashed()->find($userId)->forceDelete();
        session()->flash('message', 'Gebruiker permanent verwijderd.');
        session()->flash('message_type', 'error');
    }

    public function restore($userId)
    {
        if (!auth()->user()->can('restore users')) {
            abort(403);
        }
        User::withTrashed()->find($userId)->restore();
        session()->flash('message', 'Gebruiker hersteld.');
        session()->flash('message_type', 'success');
    }

    public function showMessage($message)
    {
        $this->message = $message;
        $this->showMessage = true;
        $this->dispatch('message-shown');
    }

    public function hideMessage()
    {
        $this->showMessage = false;
    }

    public function bulkDelete()
    {
        if (!auth()->user()->can('delete users')) {
            abort(403);
        }
        $count = count($this->selectedUsers);
        User::whereIn('id', $this->selectedUsers)->delete();
        $this->selectedUsers = [];
        $this->selectAll = false;
        session()->flash('message', $count . ' gebruiker(s) verwijderd.');
        session()->flash('message_type', 'error');
    }

    public function bulkRestore()
    {
        if (!auth()->user()->can('restore users')) {
            abort(403);
        }
        $count = count($this->selectedUsers);
        User::whereIn('id', $this->selectedUsers)->restore();
        $this->selectedUsers = [];
        $this->selectAll = false;
        session()->flash('message', $count . ' gebruiker(s) hersteld.');
        session()->flash('message_type', 'success');
    }

    public function bulkForceDelete()
    {
        if (!auth()->user()->can('force delete users')) {
            abort(403);
        }
        $count = count($this->selectedUsers);
        User::whereIn('id', $this->selectedUsers)->forceDelete();
        $this->selectedUsers = [];
        $this->selectAll = false;
        session()->flash('message', $count . ' gebruiker(s) permanent verwijderd.');
        session()->flash('message_type', 'error');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $users = User::query()
                ->with('roles')  // Eager load de roles
                ->when($this->search, function ($query) {
                    $query->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->showDeleted, function ($query) {
                    $query->withTrashed();
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->get();
                
            $this->selectedUsers = $users->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function toggleSelect($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }
        
        // Update selectAll status door de zichtbare gebruikers te tellen
        $visibleUsers = User::query()
            ->with('roles')  // Eager load de roles
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->showDeleted, function ($query) {
                $query->withTrashed();
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
            
        $this->selectAll = count($this->selectedUsers) === $visibleUsers->count();
    }

    public function exportCsv()
    {
        return Excel::download(new UsersExport($this->getExportQuery()), 'users.csv');
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport($this->getExportQuery()), 'users.xlsx');
    }

    private function getExportQuery()
    {
        return User::query()
            ->with('roles')  // Eager load de roles
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->showDeleted, function ($query) {
                $query->withTrashed();
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        return view('livewire.users.show-users', [
            'users' => User::query()
                ->with('roles')  // Eager load de roles
                ->when($this->search, function ($query) {
                    $query->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->showDeleted, function ($query) {
                    $query->withTrashed();
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'can' => [
                'create' => auth()->user()->can('create users'),
                'edit' => auth()->user()->can('edit users'),
                'delete' => auth()->user()->can('delete users'),
                'restore' => auth()->user()->can('restore users'),
                'forceDelete' => auth()->user()->can('force delete users'),
                'assignRoles' => auth()->user()->can('assign roles'),
                'removeRoles' => auth()->user()->can('remove roles'),
            ]
        ]);
    }

    /**
     * Start inline editing voor een gebruiker
     */
    public function startEditing($userId)
    {
        $user = User::find($userId);
        $this->editingUserId = $userId;
        $this->editingName = $user->name;
        $this->editingEmail = $user->email;
        $this->editingPassword = '';
        $this->editingPasswordConfirmation = '';
    }

    /**
     * Stop inline editing
     */
    public function cancelEditing()
    {
        $this->resetEditing();
    }

    /**
     * Reset alle editing properties
     */
    private function resetEditing()
    {
        $this->editingUserId = null;
        $this->editingName = '';
        $this->editingEmail = '';
        $this->editingPassword = '';
        $this->editingPasswordConfirmation = '';
    }

    /**
     * Update een gebruiker via inline editing
     */
    public function updateInline()
    {
        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingEmail' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->editingUserId)],
            'editingPassword' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($this->editingUserId);
        $user->update([
            'name' => $this->editingName,
            'email' => $this->editingEmail,
        ]);

        if ($this->editingPassword) {
            $user->update([
                'password' => Hash::make($this->editingPassword)
            ]);
        }

        session()->flash('message', 'Gebruiker succesvol bijgewerkt.');
        session()->flash('message_type', 'success');

        $this->resetEditing();
    }

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $query = User::query()
            ->with('roles') // Laad de rollen mee
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            }, function ($query) {
                $query->latest();
            });

        $this->users = $query->get();
    }
}

