<div class="p-6 bg-white shadow-md rounded-lg text-center mt-8 max-w-md mx-auto">
    <h2 class="text-xl font-semibold mb-4">Counter</h2>

    <p class="text-lg mb-4">
        Count: <span class="text-blue-600 font-bold">{{ $count }}</span>
    </p>

    <div class="flex justify-center gap-4">
        <button
            wire:click="decrement"
            @disabled($count <= $min)
            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded shadow transition-transform transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $count <= $min ? 'disabled' : '' }}>
            –
        </button>

        <button
            wire:click="increment"
            @disabled($count >= $max)
            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded shadow transition-transform transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $count >= $max ? 'disabled' : '' }}>
            +
        </button>

        <button
            wire:click="resetCount"
            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded shadow transition-transform transform hover:-translate-y-0.5">
            Reset
        </button>
    </div>
</div>
