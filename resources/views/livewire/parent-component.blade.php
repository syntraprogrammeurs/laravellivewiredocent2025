<div class="p-6 max-w-md mx-auto bg-white shadow-md rounded">
    <h2 class="text-xl font-semibold mb-4">Oudercomponent</h2>

    @if($message)
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <livewire:child-component />
</div>
