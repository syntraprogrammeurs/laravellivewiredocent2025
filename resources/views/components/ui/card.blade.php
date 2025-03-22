<div {{ $attributes->merge(['class' => 'p-6 bg-white rounded-xl shadow-lg max-w-xl mx-auto mt-6']) }}>
    <h2 class="text-xl font-bold text-gray-800 text-center mb-4">{{ $title }}</h2>

    {{-- Hier wordt de inhoud van het kaartslot getoond --}}
    {{ $slot }}
</div>
