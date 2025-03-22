<div
    class="p-6 mt-3 bg-white shadow-md rounded-lg max-w-md mx-auto mt-6"
    x-data
    @focus-input.window="$refs.name.focus()"
>
    {{-- Titel --}}
    <h2 class="text-xl font-semibold mb-4 text-center">Focus Input via JavaScript</h2>

    {{-- Inputveld dat we willen focus geven --}}
    <input
        type="text"
        x-ref="name"
        class="w-full border px-4 py-2 rounded mb-4"
        placeholder="Klik op de knop om dit veld te focussen..."
    >

    {{-- Knop die een Livewire-event triggert --}}
    <button
        wire:click="triggerFocus"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded w-full"
    >
        Focus veld via JS
    </button>
</div>
