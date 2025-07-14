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
    public function index(Request $request)
    {
        $users = User::all();

        // Start building the query - Remove the isReturned filter to show all medicines
        $query = Medicine::join('boxes', 'medicines.box_id', '=', 'boxes.id')
            ->with('box.user')
            ->select('medicines.*');

        // Apply filters
        $query = $this->applyFilters($query, $request);

        // Order and paginate
        $medicines = $query->orderBy('medicines.expiration_date')
            ->simplePaginate(8)
            ->appends($request->query());

        // Get filter values for form persistence
        $filters = $request->only([
            'status', 'medicine_name', 'stock_number', 'user_id',
            'date_received_from', 'date_received_to', 
            'expiration_from', 'expiration_to'
        ]);

        return view('inventory.medicines.index', 
            compact('medicines', 'users', 'filters'));
    }

    private function applyFilters($query, Request $request)
    {
        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'Returned') {
                $query->where('boxes.isReturned', true);
            } else {
                $query->where('boxes.isReturned', false)
                      ->where('medicines.status', $request->status);
            }
        }

        // Medicine name search
        if ($request->filled('medicine_name')) {
            $query->where('medicines.medicine_name', 'LIKE', '%' . $request->medicine_name . '%');
        }

        // Stock number search
        if ($request->filled('stock_number')) {
            $query->where('boxes.stock_number', 'LIKE', '%' . $request->stock_number . '%');
        }

        // User/MOR filter
        if ($request->filled('user_id')) {
            $query->where('boxes.user_id', $request->user_id);
        }

        // Date received range
        if ($request->filled('date_received_from')) {
            $query->whereDate('boxes.date_received', '>=', $request->date_received_from);
        }

        if ($request->filled('date_received_to')) {
            $query->whereDate('boxes.date_received', '<=', $request->date_received_to);
        }

        // Expiration date range
        if ($request->filled('expiration_from')) {
            $query->whereDate('medicines.expiration_date', '>=', $request->expiration_from);
        }

        if ($request->filled('expiration_to')) {
            $query->whereDate('medicines.expiration_date', '<=', $request->expiration_to);
        }

        return $query;
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

    public function show(Medicine $medicine)
    {
        // Load relationships with the medicine, but handle missing relationships gracefully
        $medicine->load([
            'box.user',
            'user'
        ]);

        // Try to load prescription relationships if they exist
        try {
            if (class_exists('App\Models\PrescriptionMedicine')) {
                $medicine->load(['prescriptionMedicines.patient']);
            }
        } catch (\Exception $e) {
            // If prescription relationships don't exist, continue without them
        }

        // Calculate additional statistics
        $stats = [
            'usage_percentage' => $medicine->initial_quantity > 0 
                ? round(($medicine->consumed_quantity / $medicine->initial_quantity) * 100, 2) 
                : 0,
            'days_until_expiry' => now()->diffInDays($medicine->expiration_date, false),
            'total_prescriptions' => 0, // Default to 0 if prescriptions don't exist
            'total_patients_served' => 0, // Default to 0 if patients don't exist
            'monthly_usage' => 0, // Default to 0
        ];

        // Try to get prescription statistics if the relationships exist
        try {
            if ($medicine->relationLoaded('prescriptionMedicines')) {
                $stats['total_prescriptions'] = $medicine->prescriptionMedicines->count();
                $stats['total_patients_served'] = $medicine->prescriptionMedicines->pluck('patient_id')->unique()->count();
                
                // Calculate monthly usage (prescriptions in last 30 days)
                $monthlyPrescriptions = $medicine->prescriptionMedicines()
                    ->where('created_at', '>=', now()->subDays(30))
                    ->sum('quantity');
                $stats['monthly_usage'] = $monthlyPrescriptions;
            }
        } catch (\Exception $e) {
            // Keep default values if relationships don't exist
        }

        // Get activity logs for this medicine
        $activityLogs = collect(); // Empty collection as fallback
        try {
            $activityLogs = activity()
                ->performedOn($medicine)
                ->with('causer')
                ->latest()
                ->take(10)
                ->get();
        } catch (\Exception $e) {
            // If activity logging is not set up, use empty collection
        }

        return view('inventory.medicines.show', compact('medicine', 'stats', 'activityLogs'));
    }
}

