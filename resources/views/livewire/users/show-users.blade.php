{{-- 📁 resources/views/livewire/users/show-users.blade.php --}}

<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-4">
            <h2 class="text-2xl font-semibold">Gebruikersoverzicht</h2>
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model.live="showDeleted" class="form-checkbox h-4 w-4 text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Toon verwijderde gebruikers</span>
            </label>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Zoek gebruikers..."
                    class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <x-ui.flash-message 
            :message="session('message')"
            :type="session('message_type', 'success')"
        />
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <!-- Export knoppen -->
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">Exporteer gebruikers:</span>
                    <div class="flex space-x-2">
                        <button wire:click="exportCsv" 
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            CSV
                        </button>
                        <button wire:click="exportExcel" 
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Excel
                        </button>
                    </div>
                </div>
                <a href="{{ route('users.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Nieuwe gebruiker
                </a>
            </div>
        </div>

        <!-- Bulk acties toolbar -->
        @if(count($selectedUsers) > 0)
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">
                            {{ count($selectedUsers) }} gebruikers geselecteerd
                        </span>
                        <div class="flex space-x-2">
                            <button wire:click="bulkDelete" wire:confirm="Weet je zeker dat je de geselecteerde gebruikers wilt verwijderen?" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Verwijderen
                            </button>
                            @if($showDeleted)
                                <button wire:click="bulkRestore" wire:confirm="Weet je zeker dat je de geselecteerde gebruikers wilt herstellen?" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Herstellen
                                </button>
                                <button wire:click="bulkForceDelete" wire:confirm="Weet je zeker dat je de geselecteerde gebruikers permanent wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt." class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                                    Permanent verwijderen
                                </button>
                            @endif
                        </div>
                    </div>
                    <button wire:click="$set('selectedUsers', [])" class="text-sm text-gray-500 hover:text-gray-700">
                        Selectie opheffen
                    </button>
                </div>
            </div>
        @endif

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2">Selecteer</span>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('name')" class="flex items-center space-x-1 hover:text-gray-700 group">
                            <span>Naam</span>
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortField === 'name' && $sortDirection === 'asc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="w-3 h-3 {{ $sortField === 'name' && $sortDirection === 'desc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @if($sortField === 'name')
                                <span class="text-blue-500 text-xs ml-1">({{ $sortDirection === 'asc' ? 'oplopend' : 'aflopend' }})</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('email')" class="flex items-center space-x-1 hover:text-gray-700 group">
                            <span>E-mailadres</span>
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortField === 'email' && $sortDirection === 'asc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="w-3 h-3 {{ $sortField === 'email' && $sortDirection === 'desc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @if($sortField === 'email')
                                <span class="text-blue-500 text-xs ml-1">({{ $sortDirection === 'asc' ? 'oplopend' : 'aflopend' }})</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('created_at')" class="flex items-center space-x-1 hover:text-gray-700 group">
                            <span>Geregistreerd op</span>
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortField === 'created_at' && $sortDirection === 'asc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="w-3 h-3 {{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @if($sortField === 'created_at')
                                <span class="text-blue-500 text-xs ml-1">({{ $sortDirection === 'asc' ? 'oplopend' : 'aflopend' }})</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
        </tr>
        </thead>
            <tbody class="bg-white divide-y divide-gray-200">
        @forelse($users as $user)
                    <tr class="{{ $user->trashed() ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   wire:model.live="selectedUsers" 
                                   value="{{ $user->id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('d-m-Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                @if($user->trashed())
                                    <button 
                                        wire:click="restore({{ $user->id }})"
                                        wire:confirm="Weet je zeker dat je deze gebruiker wilt herstellen?"
                                        class="text-green-600 hover:text-green-900 group relative"
                                        title="Herstellen"
                                    >
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 011 1v2a1 1 0 01-1 1h-1v6a1 1 0 01-1 1H6a1 1 0 01-1-1v-6H4a1 1 0 01-1-1V5a1 1 0 011-1h3V2zm2 5a1 1 0 100 2h8a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                            Herstellen
                                        </span>
                                    </button>
                                    <button 
                                        wire:click="forceDelete({{ $user->id }})"
                                        wire:confirm="Weet je zeker dat je deze gebruiker permanent wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt."
                                        class="text-red-600 hover:text-red-900 group relative"
                                        title="Permanent verwijderen"
                                    >
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                            Permanent verwijderen
                                        </span>
                                    </button>
                                @else
                                    <button 
                                        wire:click="delete({{ $user->id }})"
                                        wire:confirm="Weet je zeker dat je deze gebruiker wilt verwijderen?"
                                        class="text-red-600 hover:text-red-900 group relative"
                                        title="Verwijderen"
                                    >
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                            Verwijderen
                                        </span>
                                    </button>
                                @endif
                            </div>
                </td>
            </tr>
        @empty
            <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Geen gebruikers gevonden.
                        </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
