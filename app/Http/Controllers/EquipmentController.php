<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\User;
use App\Http\Requests\EquipmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $equipment = Equipment::with('user')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(8);

        return view('inventory.equipment.index', 
            compact('equipment', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request)
    {
        $validated = $request->validated();

        // Set checkbox values (1 if checked, 0 if unchecked)
        $booleanFields = [
            'serviceable',
            'for_repair',
            'for_condemn',
            'need_replacement',
            'additional'
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? 1 : 0;
        }
        
        // Create equipment
        Equipment::create($validated);

        return redirect()->route('inventory-equipment')->with([
            'action' => 'add',
            'message' => "Equipment '{$validated['general_description']}' has been added successfully."
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EquipmentRequest $request, Equipment $equipment)
    {
        $validated = $request->validated();

        // Set checkbox values (1 if checked, 0 if unchecked)
        $booleanFields = [
            'serviceable',
            'for_repair',
            'for_condemn',
            'need_replacement',
            'additional'
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? 1 : 0;
        }
        
        $equipment->update($validated);

        return redirect()->route('inventory-equipment')->with([
            'action' => 'edit',
            'message' => "Equipment '{$equipment->general_description}' has been updated successfully."
        ]);
    }

    public function deduct(Request $request, Equipment $medicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Equipment $equipment)
    {
        try {
            // Store equipment name before deletion
            $equipmentName = $equipment->general_description;
            
            $equipment->delete();
            
            return redirect()->route('inventory-equipment')->with([
                'action' => 'delete',
                'message' => "Equipment '{$equipmentName}' has been deleted successfully."
            ]);

        } catch (\Exception $e) {
            return redirect()->route('inventory-equipment')
                ->with('error', 'An error occurred while deleting the equipment.');
        }
    }
}
