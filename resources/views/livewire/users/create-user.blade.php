<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @if (session()->has('message'))
            <x-ui.flash-message 
                :message="session('message')"
                :type="session('message_type', 'success')"
            />
        @endif

        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Nieuwe Gebruiker</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Maak een nieuwe gebruiker aan voor het systeem.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit="save">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                                <input type="text" wire:model="name" id="name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-ui.forms.error error="name" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                                <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-ui.forms.error error="email" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                                <input type="password" wire:model="password" id="password" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-ui.forms.error error="password" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Bevestig Wachtwoord</label>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                                <select wire:model="role" id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <x-ui.forms.error error="role" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <x-ui.button type="submit">
                            Opslaan
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
