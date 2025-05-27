<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Boxes;
use App\Models\User;
use App\Http\Requests\SupplyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        
        $supplies = Supply::join('boxes', 'supplies.box_id', '=', 'boxes.id')
            ->where('boxes.isReturned', false)
            ->with('box.user')
            ->orderBy('supplies.expiration_date')
            ->select('supplies.*')
            ->simplePaginate(8);

        return view('inventory.supplies.index', 
            compact('supplies', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplyRequest $request)
    {
        try {
            $validated = $request->validated();

            DB::beginTransaction();

            // Create box
            $box = Boxes::create([
                'date_received' => $validated['date_received'],
                'stock_number' => $validated['stock_number'],
                'isReturned' => false,
                'user_id' => $validated['user_id']
            ]);

            // Create supply with box relationship
            Supply::create([
                'supply_name' => $validated['supply_name'],
                'unit' => $validated['unit_of_measurement'],
                'initial_quantity' => $validated['initial_quantity'],
                'remaining_quantity' => $validated['initial_quantity'],
                'consumed_quantity' => 0,
                'expiration_date' => $validated['expiration_date'],
                'status' => 'Full',
                'box_id' => $box->id,
                'user_id' => $validated['user_id']
            ]);

            DB::commit();

            return redirect()->route('inventory-supplies')->with([
                'action' => 'add',
                'message' => "Supply '{$validated['supply_name']}' has been added successfully."
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['error' => 'Failed to create supply. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply)
    {
        $users = User::all();
        return view('inventory.supplies.edit', compact('supply', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplyRequest $request, Supply $supply)
    {
        try {
            $validated = $request->validated();

            // Validate quantity constraints
            if ($validated['initial_quantity'] < $validated['consumed_quantity']) {
                throw ValidationException::withMessages([
                    'consumed_quantity' => ['Consumed quantity cannot be greater than initial quantity.']
                ]);
            }

            if ($validated['consumed_quantity'] > $supply->initial_quantity) {
                throw ValidationException::withMessages([
                    'consumed_quantity' => ['Consumed quantity cannot exceed the initial quantity.']
                ]);
            }

            // Calculate remaining quantity
            $remainingQuantity = $validated['initial_quantity'] - $validated['consumed_quantity'];

            // Update box information
            $supply->box->update([
                'date_received' => $validated['date_received'],
                'stock_number' => $validated['stock_number'],
                'user_id' => $validated['user_id']
            ]);

            // Update supply
            $supply->update([
                'supply_name' => $validated['supply_name'],
                'unit' => $validated['unit_of_measurement'],
                'initial_quantity' => $validated['initial_quantity'],
                'consumed_quantity' => $validated['consumed_quantity'],
                'remaining_quantity' => $remainingQuantity,
                'expiration_date' => $validated['expiration_date'],
                'user_id' => $validated['user_id']
            ]);

            return redirect()->route('inventory-supplies')->with([
                'action' => 'edit',
                'message' => "Supply '{$validated['supply_name']}' has been updated successfully."
            ]);

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    protected function validateQuantities($initial, $consumed, Supply $supply)
    {
        if ($initial < $consumed) {
            throw ValidationException::withMessages([
                'initial_quantity' => ['Initial quantity cannot be less than consumed quantity.']
            ]);
        }

        if ($consumed > $supply->remaining_quantity) {
            throw ValidationException::withMessages([
                'consumed_quantity' => ['Consumed quantity cannot exceed current remaining quantity.']
            ]);
        }
    }

    public function deduct(Request $request, Supply $medicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Supply $supply)
    {
        try {
            // Store supply name before deletion
            $supplyName = $supply->supply_name;
            
            $supply->delete();
            
            return redirect()->route('inventory-supplies')->with([
                'action' => 'delete',
                'message' => "Supply '{$supplyName}' has been deleted successfully."
            ]);

        } catch (\Exception $e) {
            return redirect()->route('inventory-supplies')
                ->with('error', 'An error occurred while deleting the supply.');
        }
    }
    
    /**
     * Mark the specified supply as returned.
     */
    public function return(Supply $supply)
    {
        // Update the box associated with this supply
        $supply->box->update(['isReturned' => true]);

        return redirect()->back()->with([
            'action' => 'return',
            'message' => "Supply '{$supply->supply_name}' has been returned successfully."
        ]);
    }
}
