<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicinesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Medicine::with(['box', 'box.user'])->get();
    }

    public function headings(): array
    {
        return [
            'Date Received',
            'Stock #',
            'Medicine Name',
            'Unit',
            'Initial Quantity',
            'Consumed',
            'Balance',
            'Expiration Date',
            'MOR',
        ];
    }

    public function map($medicine): array
    {
        return [
            \Carbon\Carbon::parse($medicine->box->date_received)->format('Y-m-d'),
            $medicine->box->stock_number,
            $medicine->medicine_name,
            $medicine->unit,
            $medicine->initial_quantity,
            $medicine->consumed_quantity,
            $medicine->remaining_quantity,
            \Carbon\Carbon::parse($medicine->expiration_date)->format('Y-m-d'),
            $medicine->box->user->first_name,
        ];
    }
}
