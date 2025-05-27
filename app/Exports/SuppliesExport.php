<?php

namespace App\Exports;

use App\Models\Supply;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuppliesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Supply::with(['box', 'box.user'])->get();
    }

    public function headings(): array
    {
        return [
            'Date Received',
            'Stock #',
            'Supply Name',
            'Unit',
            'Initial Quantity',
            'Consumed',
            'Balance',
            'MOR',
        ];
    }

    public function map($supply): array
    {
        return [
            \Carbon\Carbon::parse($supply->box->date_received)->format('Y-m-d'),
            $supply->box->stock_number,
            $supply->supply_name,
            $supply->unit,
            $supply->initial_quantity,
            $supply->consumed_quantity,
            $supply->remaining_quantity,
            $supply->box->user->first_name,
        ];
    }
}
