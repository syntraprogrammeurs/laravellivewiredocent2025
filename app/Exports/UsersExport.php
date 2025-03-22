<?php

namespace App\Exports;

// Interfaces van Laravel Excel voor query-gebaseerde export, kolomtitels en aangepaste rijen
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// Eloquent Builder voor typehinting van de query
use Illuminate\Database\Eloquent\Builder;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * De query die de data zal leveren voor de export.
     * Deze wordt vanuit de Livewire-component dynamisch meegegeven.
     */
    protected $query;

    /**
     * Constructor ontvangt de query vanuit Livewire component
     *
     * @param Builder $query - De gefilterde, gesorteerde query die geëxporteerd moet worden
     */
    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * Geeft de query terug die gebruikt zal worden door Laravel Excel
     *
     * @return Builder
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Definieert de koppen (kolomtitels) van het exportbestand (eerste rij in Excel of CSV)
     *
     * @return array<string>
     */
    public function headings(): array
    {
        return [
            'ID',
            'Naam',
            'E-mailadres',
            'Geregistreerd op',
            'Status', // Bijvoorbeeld 'Actief' of 'Verwijderd'
        ];
    }

    /**
     * Maakt de mapping van elk record (User) naar een rij in het exportbestand.
     * Hiermee bepaal je welke velden en in welk formaat ze geëxporteerd worden.
     *
     * @param \App\Models\User $user
     * @return array<string>
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('d-m-Y H:i:s'), // Datum op leesbare manier
            $user->trashed() ? 'Verwijderd' : 'Actief', // Soft delete status
        ];
    }
}
