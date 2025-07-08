<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlNumber;

class ControlNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            'Excuse Letter',
            'Annual Medical Clearance',
            'Medical Clearance',
            'Medical Certficate',
            'DMDC Consent Form',
            'Waiver',
            'Waiver for Pulmonary Case',
        ];

        foreach ($documentTypes as $index => $type) {
            ControlNumber::create([
                'document_type'   => $type,
                'control_number'  => 'PUP-MCPF-6-MEDS-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'revision'        => 1,
                'date_issued'     => now()->toDateString(),
            ]);
        }
    }
}
