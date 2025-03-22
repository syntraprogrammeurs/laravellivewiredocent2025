<?php

// 📁 app/Livewire/Users/ShowUsers.php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

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

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        $this->showMessage('Gebruiker succesvol verwijderd.');
    }

    public function forceDelete($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $user->forceDelete();
        $this->showMessage('Gebruiker permanent verwijderd.');
    }

    public function restore($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $user->restore();
        $this->showMessage('Gebruiker succesvol hersteld.');
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
        $count = count($this->selectedUsers);
        User::whereIn('id', $this->selectedUsers)->delete();
        
        $this->selectedUsers = [];
        $this->selectAll = false;
        
        $this->showMessage($count . ' gebruikers zijn verwijderd.');
    }

    public function bulkRestore()
    {
        $count = count($this->selectedUsers);
        User::withTrashed()
            ->whereIn('id', $this->selectedUsers)
            ->restore();
        
        $this->selectedUsers = [];
        $this->selectAll = false;
        
        $this->showMessage($count . ' gebruikers zijn hersteld.');
    }

    public function bulkForceDelete()
    {
        $count = count($this->selectedUsers);
        User::withTrashed()
            ->whereIn('id', $this->selectedUsers)
            ->forceDelete();
        
        $this->selectedUsers = [];
        $this->selectAll = false;
        
        $this->showMessage($count . ' gebruikers zijn permanent verwijderd.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $users = User::query()
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
        ]);
    }
}

