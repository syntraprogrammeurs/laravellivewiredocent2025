<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Gebruiker Bewerken</h2>
                        <p class="mt-1 text-sm text-gray-600">Bewerk de gegevens van de gebruiker</p>
                    </div>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Terug naar overzicht
                    </a>
                </div>

                @if (session()->has('message'))
                    <x-ui.flash-message 
                        :message="session('message')"
                        :type="session('message_type', 'success')"
                    />
                @endif

                <form wire:submit="update" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Naam -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                            <div class="mt-1">
                                <input type="text" wire:model="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Volledige naam">
                            </div>
                            @error('name') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                            <div class="mt-1">
                                <input type="email" wire:model="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="email@example.com">
                            </div>
                            @error('email') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Wachtwoord -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                            <div class="mt-1">
                                <input type="password" wire:model="password" id="password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Laat leeg om niet te wijzigen">
                            </div>
                            @error('password') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Wachtwoord Bevestigen -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Wachtwoord Bevestigen</label>
                            <div class="mt-1">
                                <input type="password" wire:model="password_confirmation" id="password_confirmation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Laat leeg om niet te wijzigen">
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                            <div class="mt-1">
                                <select wire:model="role" id="role" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuleren
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 