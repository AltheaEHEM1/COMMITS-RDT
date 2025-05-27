<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipmentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Equipment::with(['box', 'box.user'])->get();
    }

    public function headings(): array
    {
        return [
            'Date Received',
            'Stock #',
            'Equipment Name',
            'Description',
            'Quantity',
            'Status',
            'MOR',
        ];
    }

    public function map($equipment): array
    {
        return [
            \Carbon\Carbon::parse($equipment->box->date_received)->format('Y-m-d'),
            $equipment->box->stock_number,
            $equipment->equipment_name,
            $equipment->description,
            $equipment->quantity,
            $equipment->status,
            $equipment->box->user->first_name,
        ];
    }
}
