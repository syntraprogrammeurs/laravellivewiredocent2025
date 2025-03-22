<div class="p-6 bg-white shadow-md rounded-lg max-w-md mx-auto space-y-4">
    <h2 class="text-xl font-semibold text-center">Registratieformulier</h2>

    {{-- Success message --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Voornaam --}}
    <div>
        <label for="firstName" class="block font-medium text-gray-700">Voornaam</label>
        <input
            id="firstName"
            type="text"
            wire:model.live.debounce.500ms="firstName"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('firstName') border-red-500 @enderror"
            placeholder="Typ je voornaam...">
        @error('firstName')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Achternaam --}}
    <div>
        <label for="lastName" class="block font-medium text-gray-700">Achternaam</label>
        <input
            id="lastName"
            type="text"
            wire:model.lazy="lastName"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('lastName') border-red-500 @enderror"
            placeholder="Typ je achternaam...">
        @error('lastName')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- E-mailadres --}}
    <div>
        <label for="email" class="block font-medium text-gray-700">E-mailadres</label>
        <input
            id="email"
            type="email"
            wire:model.defer="email"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror"
            placeholder="Typ je e-mailadres...">
        @error('email')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Actieknoppen --}}
    <div class="flex justify-between items-center pt-2">
        <button
            wire:click="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Verzenden
        </button>

        <button
            wire:click="resetForm"
            type="button"
            class="text-blue-600 hover:underline text-sm">
            Reset
        </button>
    </div>
</div>
