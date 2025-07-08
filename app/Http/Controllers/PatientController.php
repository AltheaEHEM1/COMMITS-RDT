<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Medicine;
use App\Models\PrescriptionMedicine;
use App\Services\PatientService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Patient service instance
     *
     * @var \App\Services\PatientService
     */
    protected $patientService;

    /**
     * Create a new controller instance
     *
     * @param \App\Services\PatientService $patientService
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Display a listing of patients
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patients = Patient::with(['physician', 'prescriptionMedicines.medicine'])->get();
        $physicians = User::where('status', 'active')
             ->where('is_activated', true)
             ->get();
        $medicines = Medicine::whereHas('box', function ($query) {
            $query->where('isReturned', 0);
        })->get();

        return view('patient.patients', compact('patients', 'physicians', 'medicines'));
    }

    /**
     * Show the form for adding a new patient
     *
     * @return \Illuminate\View\View
     */
    public function add()
    {
        $physicians = User::where('role', 'admin')->get();
        return view('patient.add', compact('physicians'));
    }

    public function checkSimilar(Request $request)
    {
        // If there are literally no patients yet, skip the fuzzy‐search entirely:
        if (Patient::count() === 0) {
            return response()->json([
                'similarFound'    => false,
                'similarPatients' => [],
            ]);
        }

        $first  = $request->input('firstName');
        $middle = $request->input('middleName');
        $last   = $request->input('lastName');

        $query = trim(implode(' ', array_filter([$first, $middle, $last])));

        if (empty($query)) {
            return response()->json([
                'similarFound'    => false,
                'similarPatients' => [],
            ]);
        }

        try {
            $results = Patient::search($query)->get();
        } catch (\Throwable $e) {
            Log::error('checkSimilar failed: '.$e->getMessage());
            return response()->json([
                'message' => 'Search service error — please try again later.'
            ], 500);
        }

        return response()->json([
            'similarFound'    => $results->isNotEmpty(),
            'similarPatients' => $results->map(fn($p) => [
                'id'         => $p->id,
                'firstName'  => $p->firstName,
                'middleName' => $p->middleName,
                'lastName'   => $p->lastName,
                'full_name'  => "{$p->firstName} {$p->middleName} {$p->lastName}",
            ]),
        ]);
    }


    /**
     * Show the form for creating a new patient (alias for add)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->add();
    }

    /**
     * Store a newly created patient in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data.
            $validated = $request->validate(
                Patient::validationRules(),
                Patient::validationMessages()
            );

            // Trim and extract the name fields.
            $first  = trim($validated['firstName'] ?? '');
            $middle = trim($validated['middleName'] ?? '');
            $last   = trim($validated['lastName'] ?? '');

            // Check for an exact duplicate. Adjust the query as needed.
            $duplicate = Patient::query()
                ->whereRaw('LOWER(firstName) = ?', [strtolower($first)])
                ->whereRaw('LOWER(lastName) = ?', [strtolower($last)])
                ->when(!empty($middle), function ($query) use ($middle) {
                    $query->whereRaw('LOWER(middleName) = ?', [strtolower($middle)]);
                })
                ->first();

            if ($duplicate) {
                // If a duplicate is found, return an error response.
                return response()->json([
                    'success' => false,
                    'message' => 'A patient with this name already exists.',
                ], 422);
            }

            // If no duplicate is found, proceed with saving the patient.
            $patient = $this->patientService->executeTransaction(function () use ($validated) {
                return $this->patientService->createPatient($validated);
            });

            return response()->json([
                'success' => true,
                'message' => 'Patient added successfully',
                'data'    => $patient
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check the form and try again.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Patient creation error: ' . $e->getMessage(), [
                'request' => $request->except(['_token']),
                'trace'   => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the patient. Please try again later.'
            ], 500);
        }
    }

    /**
     * Update the specified patient
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the patient by ID
            $patient = Patient::findOrFail($id);

            // Apply validation rules from the Patient model
            $validated = $request->validate(
                Patient::validationRules(),
                Patient::validationMessages()
            );

            $updatedPatient = $this->patientService->executeTransaction(function () use ($patient, $validated) {
                return $this->patientService->updatePatient($patient, $validated);
            });

            return response()->json([
                'success' => true,
                'message' => 'Patient information updated successfully',
                'data' => $updatedPatient
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check the form and try again.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found. The patient may have been deleted.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Patient update error: ' . $e->getMessage(), [
                'patient_id' => $id,
                'request' => $request->except(['_token']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the patient. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified patient from database
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            // Find patient by ID
            $patient = Patient::findOrFail($id);

            $this->patientService->executeTransaction(function () use ($patient) {
                return $this->patientService->deletePatient($patient);
            });

            // Redirect back with success message
            return redirect()->route('patients')->with('success', 'Patient deleted successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('patients')->with('error', 'Patient not found. The patient may have been deleted already.');
        } catch (\Exception $e) {
            Log::error('Patient deletion error: ' . $e->getMessage(), [
                'patient_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('patients')->with('error', 'An error occurred while deleting the patient. Please try again later.');
        }
    }

    /**
     * Show the form for editing the specified patient
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\View\View
     */
    public function edit(Patient $patient)
    {
        $physicians = User::where('role', 'admin')->get();
        return view('patient.edit', compact('patient', 'physicians'));
    }

    /**
     * Store a new prescription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePrescription(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'medicine_id' => 'required|exists:medicines,id',
                'quantity' => 'required|integer|min:1',
                'instructions' => 'nullable|string|max:1000'
            ], [
                'patient_id.required' => 'Patient information is missing',
                'patient_id.exists' => 'The selected patient is not valid',
                'medicine_id.required' => 'Medicine selection is required',
                'medicine_id.exists' => 'The selected medicine is not valid',
                'quantity.required' => 'Quantity is required',
                'quantity.integer' => 'Quantity must be a whole number',
                'quantity.min' => 'Quantity must be at least 1',
                'instructions.max' => 'Instructions cannot exceed 1000 characters'
            ]);

            $result = $this->patientService->executeTransaction(function () use ($validated) {
                return $this->patientService->createPrescription($validated);
            });

            $prescription = $result['prescription'];
            $medicine = $result['medicine'];

            return response()->json([
                'success' => true,
                'message' => "Prescription created successfully. Remaining {$medicine['name']}: {$medicine['remaining_quantity']} {$medicine['unit']}",
                'prescription' => $prescription,
                'medicine' => $medicine
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check the form and try again.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Medicine or patient not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Prescription creation error: ' . $e->getMessage(), [
                'request' => $request->except(['_token']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred while creating the prescription. Please try again later.'
            ], 500);
        }
    }

    /**
     * Get prescriptions for a patient
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrescriptions(Patient $patient)
    {
        try {
            $prescriptions = $this->patientService->getPatientPrescriptions($patient);

            return response()->json([
                'success' => true,
                'prescriptions' => $prescriptions
            ]);
        } catch (\Exception $e) {
            Log::error('Prescription retrieval error: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve prescriptions. Please try again later.'
            ], 500);
        }
    }
}