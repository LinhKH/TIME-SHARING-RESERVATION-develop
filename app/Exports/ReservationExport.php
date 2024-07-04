<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservationExport implements FromCollection, WithHeadings
{

    /**
     * @const string typeReservation
     */
    public $typeReservation;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->typeReservation = $type;
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first()->toArray());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        switch ($this->typeReservation) {
            case 'first-contractor':
                return Reservation::whereNotNull('first_contractor_id')->get();
                break;

            default:
                return Reservation::all();
                break;
        }
    }
}
