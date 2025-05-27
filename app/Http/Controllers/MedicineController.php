<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineRequest; // We'll create this
use App\Models\Boxes;
use App\Models\Medicine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MedicineController extends Controller
{
    public function index()
    {
        $users = User::all();

        $medicines = Medicine::join('boxes', 'medicines.box_id', '=', 'boxes.id')
            ->where('boxes.isReturned', false)
            ->with('box.user')
            ->orderBy('medicines.expiration_date')
            ->select('medicines.*')
            ->simplePaginate(8);

        return view('inventory.medicines.index', 
            compact('medicines', 'users'));
    }

    public function create(){
        $users = User::all();
        return view('medicine.add_medicine', compact('users'));
    }

    public function store(MedicineRequest $request)
    {
        $validated = $request->validated();

        // Create box
        $box = Boxes::create([
            'date_received' => $validated['date_received'],
            'stock_number' => $validated['stock_number'],
            'isReturned' => false,
            'user_id' => $validated['user_id']
        ]);

        // Create medicine with relationship
        $medicine = $box->medicine()->create([
            'medicine_name' => $validated['medicine_name'],
            'unit' => $validated['unit_of_measurement'],
            'initial_quantity' => $validated['initial_quantity'],
            'remaining_quantity' => $validated['initial_quantity'],
            'consumed_quantity' => 0,
            'expiration_date' => $validated['expiration_date'],
            'status' => 'Full',
            'user_id' => $validated['user_id']
        ]);

        return redirect()->route('inventory-medicines')->with([
            'action' => 'add',
            'message' => "Medicine '{$validated['medicine_name']}' has been added successfully."
        ]);
    }

    public function update(MedicineRequest $request, Medicine $medicine)
    {
        $data = $request->validated();

        // Calculate remaining quantity
        $remainingQty = $data['initial_quantity'] - $medicine->consumed_quantity;
        $remainingQty = max(0, $remainingQty);

        // Calculate status
        $status = $this->calculateMedicineStatus($remainingQty, $data['initial_quantity']);

        // Update medicine
        $medicine->update([
            'medicine_name' => $data['medicine_name'],
            'initial_quantity' => $data['initial_quantity'],
            'remaining_quantity' => $remainingQty,
            'unit' => $data['unit_of_measurement'],
            'expiration_date' => $data['expiration_date'],
            'status' => $status
        ]);

        // Update box
        $medicine->box->update([
            'stock_number' => $data['stock_number'],
            'date_received' => $data['date_received'],
            'user_id' => $data['user_id']
        ]);

        return redirect()->route('inventory-medicines')->with([
            'action' => 'edit',
            'message' => "Medicine '{$data['medicine_name']}' has been updated successfully."
        ]);
    }

    private function calculateMedicineStatus($remaining, $initial)
    {
        if ($remaining == $initial) return 'Full';
        if ($remaining == 0) return 'Out of Stock';
        if ($remaining <= ($initial * 0.2)) return 'Low Stock';
        return 'In Stock';
    }

    public function deduct(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'quantity' => 'required|numeric|min:0.01|max:'.$medicine->remaining_quantity,
        ]);

        $medicine->update([
            'consumed_quantity' => $medicine->consumed_quantity + $data['quantity'],
            'remaining_quantity' => $medicine->remaining_quantity - $data['quantity'],
            'status' => $medicine->remaining_quantity - $data['quantity'] == $medicine->initial_quantity ? 'Full' :
                    ($medicine->remaining_quantity - $data['quantity'] == 0 ? 'Out of Stock' :
                    ($medicine->remaining_quantity - $data['quantity'] <= ($medicine->initial_quantity * 0.2) ? 'Low Stock' : 'In Stock'))
        ]);

        return redirect()->route('inventory-medicines')->with([
            'action' => 'edit',
            'message' => "Medicine '{$medicine->medicine_name}' quantity has been deducted by {$data['quantity']} {$medicine->unit}."
        ]);
    }

    public function destroy(Request $request, Medicine $medicine)
    {
        try {
            // Store medicine name before deletion
            $medicineName = $medicine->medicine_name;
            
            // Get box ID before deleting medicine
            $boxId = $medicine->box_id;
            
            // Delete the medicine
            $medicine->delete();
            
            // Check if there are no other medicines linked to this box
            $box = Boxes::find($boxId);
            if ($box && !$box->medicine()->exists()) {
                $box->delete();
            }

            return redirect()->route('inventory-medicines')->with([
                'action' => 'delete',
                'message' => "Medicine '{$medicineName}' has been deleted successfully."
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error deleting medicine: ' . $e->getMessage());
            
            return redirect()->route('inventory-medicines')
                ->with('error', 'Failed to delete medicine: ' . $e->getMessage());
        }
    }

    public function return(Medicine $medicine)
    {
        $medicine->box->update(['isReturned' => true]);

        return redirect()->back()->with([
            'action' => 'return',
            'message' => "Medicine '{$medicine->medicine_name}' has been returned successfully."
        ]);
    }
}
