<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Medicine;
use App\Models\Supply;
use App\Models\Equipment;

class InventoryExportController extends Controller
{
    public function export($type)
    {
        switch ($type) {
            case 'medicines':
                return $this->exportMedicines();
            
            case 'supplies':
                return $this->exportSupplies();
            
            case 'equipment':
                return $this->exportEquipment();
                
            default:
                return redirect()->back()->with('error', 'Invalid inventory type specified');
        }
    }

    private function exportMedicines()
    {
        // Get all medicines with related data
        $medicines = Medicine::with(['box', 'box.user'])->get();
        
        // CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="medicines.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Create the file handle
        $callback = function() use ($medicines) {
            $handle = fopen('php://output', 'w');
            
            // Add header row
            fputcsv($handle, [
                'Date Received',
                'Stock #',
                'Medicine Name',
                'Unit',
                'Initial Quantity',
                'Consumed',
                'Balance',
                'Expiration Date',
                'MOR',
                'Returned'
            ]);
            
            // Add data rows
            foreach ($medicines as $medicine) {
                // Use the correct isReturned field from the boxes table through box relationship
                $isReturned = isset($medicine->box->isReturned) && $medicine->box->isReturned ? 'Yes' : 'No';
                
                fputcsv($handle, [
                    \Carbon\Carbon::parse($medicine->box->date_received)->format('Y-m-d'),
                    $medicine->box->stock_number,
                    $medicine->medicine_name,
                    $medicine->unit,
                    $medicine->initial_quantity,
                    $medicine->consumed_quantity,
                    $medicine->remaining_quantity,
                    \Carbon\Carbon::parse($medicine->expiration_date)->format('Y-m-d'),
                    $medicine->box->user->first_name,
                    $isReturned
                ]);
            }
            
            fclose($handle);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    private function exportSupplies()
    {
        // Get all supplies with related data
        $supplies = Supply::with(['box', 'box.user'])->get();
        
        // CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="supplies.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Create the file handle
        $callback = function() use ($supplies) {
            $handle = fopen('php://output', 'w');
            
            // Add header row - Remove the "Returned" column since supplies don't have a return function
            fputcsv($handle, [
                'Date Received',
                'Stock #',
                'Supply Name',
                'Unit',
                'Initial Quantity',
                'Consumed',
                'Balance',
                'MOR'
            ]);
            
            // Add data rows
            foreach ($supplies as $supply) {
                fputcsv($handle, [
                    \Carbon\Carbon::parse($supply->box->date_received)->format('Y-m-d'),
                    $supply->box->stock_number,
                    $supply->supply_name,
                    $supply->unit,
                    $supply->initial_quantity,
                    $supply->consumed_quantity,
                    $supply->remaining_quantity,
                    $supply->box->user->first_name
                ]);
            }
            
            fclose($handle);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    private function exportEquipment()
    {
        // Get all equipment with related data
        $equipments = Equipment::with(['box', 'box.user'])->get();
        
        // CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipment.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Create the file handle
        $callback = function() use ($equipments) {
            $handle = fopen('php://output', 'w');
            
            // Add header row - Remove the "Returned" column since equipment doesn't have a return function
            fputcsv($handle, [
                'Date Received',
                'Stock #',
                'Equipment Name',
                'Description',
                'Quantity',
                'Status',
                'MOR'
            ]);
            
            // Add data rows
            foreach ($equipments as $equipment) {
                fputcsv($handle, [
                    \Carbon\Carbon::parse($equipment->box->date_received)->format('Y-m-d'),
                    $equipment->box->stock_number,
                    $equipment->equipment_name,
                    $equipment->description,
                    $equipment->quantity,
                    $equipment->status,
                    $equipment->box->user->first_name
                ]);
            }
            
            fclose($handle);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
