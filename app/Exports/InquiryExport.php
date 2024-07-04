<?php

namespace App\Exports;

use App\Models\Inquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InquiryExport implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return array_keys($this->collection()->first()->toArray());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Inquiry::all();
    }
}
