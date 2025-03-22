<div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg text-center">
    <h2>Refresh</h2>
    <p class="text-lg font-semibold text-gray-700">
        De huidige tijd is: <span class="text-blue-600">{{ now() }}</span>
    </p>

    <flux:button wire:click="$refresh">
        Refresh
    </flux:button>

    <button wire:click="$refresh"
            class="cursor-pointer px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
        Refresh
    </button>
    <div wire:poll.5000ms>
        De tijd is: {{ now()->format('H:i:s') }}
    </div>
</div>


