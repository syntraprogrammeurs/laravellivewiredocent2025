{{-- 📁 resources/views/livewire/users/show-users.blade.php --}}

<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Gebruikersoverzicht</h2>

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
        <tr>
            <th class="px-4 py-2">Naam</th>
            <th class="px-4 py-2">E-mailadres</th>
            <th class="px-4 py-2">Geregistreerd op</th>
            <th class="px-4 py-2 text-right">Acties</th>
        </tr>
        </thead>
        <tbody class="text-sm text-gray-800 divide-y divide-gray-200">
        @forelse($users as $user)
            <tr>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->created_at->format('d-m-Y') }}</td>
                <td class="px-4 py-2 text-right">
                    <a href="#" class="text-blue-600 hover:underline text-sm">Bewerken</a>
                    <a href="#" class="text-red-600 hover:underline text-sm ml-3">Verwijderen</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500">Geen gebruikers gevonden.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
