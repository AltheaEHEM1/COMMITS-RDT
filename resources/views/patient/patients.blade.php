@extends('layouts.app-layout')

@section('title', 'Patients Records')

@section('content')
    <div class="container mx-auto">
        <x-page-title class="mb-2" value="Patients Records" />

 <div class="p-4 bg-white rounded-lg shadow">
    <!-- Top bar with tabs on left and button(s) on right -->
    <div class="flex items-center justify-between flex-wrap gap-4 mb-3">
        
        <!-- Tabs (left-aligned) -->
        <div class="flex space-x-3 overflow-x-auto" aria-label="Tabs">
            
            <button type="button"
                class="px-3 py-2 text-base text-gray-800 border-b-2 border-blue-500 rounded-t bg-blue-50 tab-btn whitespace-nowrap active hover:text-gray-700"
                data-filter="all">
                All Patients
            </button>
            <button type="button"
                class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
                data-filter="Student">
                Students
            </button>
            <button type="button"
                class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
                data-filter="Faculty">
                Faculty
            </button>
            <button type="button"
                class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
                data-filter="Admin">
                Administrative
            </button>
            <button type="button"
                class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
                data-filter="Visitor">
                Visitors
            </button>
            <button type="button"
                class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
                data-filter="Dependent">
                Dependents
            </button>
        </div>

        <!-- Action Buttons (right-aligned) -->
        <div class="flex gap-2">

            <!-- Add Patient button -->
          <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg active:shadow-sm transform hover:-translate-y-0.5 active:translate-y-0"
                data-bs-toggle="modal" data-bs-target="#addPatientModal">
                <span class="font-medium">+ Add Patient</span>
            </button>
        </div>
    </div>



            <!-- Table Container -->
            <div class="mt-4">
                <div class="overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-200">
                                <!-- Table headers -->
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Printed
                                            Name</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Sex</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Patient
                                            Type</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Year &
                                            Course</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Contact
                                            Number</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-bold tracking-wide text-gray-600 uppercase">Physician</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Patient
                                            Status</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left group">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-bold tracking-wide text-gray-600 uppercase">Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($patients as $patient)
                                <tr class="transition-colors duration-200 hover:bg-gray-50"
                                    data-patient-type="{{ $patient->patientType }}">
                                    <!-- Patient details -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $patient->fullname }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                            {{ $patient->sex == 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $patient->sex }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $patient->patientType }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $patient->year_course_dept }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $patient->contactDetails }}
                                    </td>
                                    <!-- Update the physician cell in your table -->
                                    <td class="px-6 py-4 text-sm text-gray-500"> Dr.
                                        @if ($patient->physician)
                                            {{ $patient->physician->first_name }} {{ $patient->physician->last_name }}
                                        @else
                                            <span class="text-gray-400">Not assigned</span>
                                        @endif
                                    <td class="px-6 py-4 text-sm text-gray-500"> {{ $patient->patient_status }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center gap-x-4">
                                            <button
                                                class="px-3 py-2 text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-900"
                                                data-bs-toggle="modal" data-bs-target="#viewPatient-{{ $patient->id }}"
                                                data-patient-id="{{ $patient->id }}" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                class="px-3 py-2 text-white transition-colors duration-200 bg-green-600 rounded-lg hover:bg-green-900"
                                                data-bs-toggle="modal"
                                                data-bs-target="#prescriptionListModal-{{ $patient->id }}"
                                                data-patient-id="{{ $patient->id }}" title="View">
                                                <i class="fas fa-prescription"></i>
                                            </button>
                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                                class="inline-block" onsubmit="return false;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this.form)"
                                                    class="px-3 py-2 text-white transition-colors duration-200 bg-red-600 rounded-lg hover:bg-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Prescription List Modal -->
                                <div class="modal fade" id="prescriptionListModal-{{ $patient->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="overflow-hidden border-0 shadow-lg modal-content rounded-xl">
                                            <!-- Modal Header with Close Button -->
                                            <div class="relative p-6 border-b border-gray-200">
                                                <div class="text-center">
                                                    <h5 class="text-xl font-semibold text-gray-900">Prescription
                                                        History</h5>
                                                    <p class="text-sm text-gray-500">{{ $patient->fullname }}</p>
                                                </div>
                                                <button type="button"
                                                    class="absolute text-gray-400 top-4 right-4 hover:text-gray-500 focus:outline-none"
                                                    data-bs-dismiss="modal">
                                                    <i class="text-xl fas fa-times"></i>
                                                </button>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="p-6">
                                                <!-- Prescriptions List -->
                                                <div class="overflow-y-auto max-h-[400px]">
                                                    @if ($patient->prescriptionMedicines->count() > 0)
                                                        @foreach ($patient->prescriptionMedicines as $prescription)
                                                            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                                                                <div class="flex items-center justify-between mb-2">
                                                                    <div class="flex items-center gap-x-2">
                                                                        <span class="text-sm font-medium text-gray-900">
                                                                            @if ($prescription->medicine)
                                                                                {{ $prescription->medicine->medicine_name }}
                                                                            @else
                                                                                <span class="text-gray-400">Medicine
                                                                                    unavailable</span>
                                                                            @endif
                                                                        </span>
                                                                        <span
                                                                            class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                                                            {{ $prescription->quantity }} units
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="text-xs text-gray-500">
                                                                            {{ $prescription->created_at->format('M d, Y') }}
                                                                        </span>
                                                                        <button type="button" 
                                                                            class="px-3 py-1.5 text-sm text-white transition-colors duration-200 bg-blue-500 rounded-lg hover:bg-blue-600"
                                                                            onclick="printPrescription({{ $prescription->id }}, '{{ $patient->fullname }}', '{{ $patient->sex }}', '{{ $patient->age ?? '' }}', '{{ $prescription->medicine ? $prescription->medicine->medicine_name : 'Medicine unavailable' }}', {{ $prescription->quantity }}, '{{ $prescription->medicine ? $prescription->medicine->unit : '' }}', '{{ $prescription->created_at->format('M d, Y') }}', '{{ $patient->physician ? $patient->physician->first_name . ' ' . $patient->physician->last_name : 'Not assigned' }}', '{{ $patient->physician ? $patient->physician->license_number ?? '' : '' }}')">
                                                                            <i class="mr-1 fas fa-print"></i> Print
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if ($prescription->medicine)
                                                                    <p class="text-sm text-gray-600">
                                                                        Available: {{ $prescription->medicine->remaining_quantity }} {{ $prescription->medicine->unit }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="py-8 text-center">
                                                            <div class="mb-4 text-gray-400">
                                                                <i class="text-4xl fas fa-prescription-bottle"></i>
                                                            </div>
                                                            <h3 class="text-lg font-medium text-gray-900">No
                                                                prescriptions yet</h3>
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                Create a new prescription using the button below.
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Create Prescription Button -->
                                                <div class="flex justify-center pt-6 mt-6 border-t border-gray-200">
                                                    <button type="button"
                                                        class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white transition-all bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-200"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#prescriptionModal-{{ $patient->id }}"
                                                        onclick="$('#prescriptionListModal-{{ $patient->id }}').modal('hide')">
                                                        <i class="mr-2 fas fa-plus-circle"></i>
                                                        Create New Prescription
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add this after your existing modals -->
                                <div class="modal fade" id="prescriptionModal-{{ $patient->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="overflow-hidden border-0 shadow-lg modal-content rounded-xl">
                                            <div class="p-6 modal-body">
                                                <form action="{{ route('prescriptions.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                                                    <!-- Modal Header -->
                                                    <div class="relative pb-5 mb-6 border-b border-gray-200">
                                                        <div class="text-center">
                                                            <h5 class="text-xl font-semibold text-gray-900">Create New
                                                                Prescription</h5>
                                                            <p class="text-sm text-gray-500">For patient:
                                                                {{ $patient->fullname }}</p>
                                                        </div>
                                                        <button type="button"
                                                            class="absolute top-0 right-0 text-gray-400 hover:text-gray-500 focus:outline-none"
                                                            data-bs-dismiss="modal">
                                                            <i class="text-xl fas fa-times"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Medicine Selection -->
                                                    <div class="space-y-4">
                                                        <div class="flex items-center gap-4">
                                                            <div class="flex-1">
                                                                <label for="medicine-select-{{ $patient->id }}"
                                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                                    Select Medicine <span class="text-red-500"> *</span>
                                                                </label>
                                                                <select id="medicine-select-{{ $patient->id }}"
                                                                    name="medicine_id"
                                                                    class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition-all"
                                                                    required>
                                                                    <option value="">Select a medicine</option>
                                                                    @foreach ($medicines as $medicine)
                                                                        <option value="{{ $medicine->id }}"
                                                                            data-remaining="{{ $medicine->remaining_quantity }}"
                                                                            data-unit="{{ $medicine->unit }}">
                                                                            {{ $medicine->medicine_name }} (Available:
                                                                            {{ $medicine->remaining_quantity }}
                                                                            {{ $medicine->unit }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="w-32">
                                                                <label for="quantity-{{ $patient->id }}"
                                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                                    Quantity <span class="text-red-500"> *</span>
                                                                </label>
                                                                <input type="number" id="quantity-{{ $patient->id }}"
                                                                    name="quantity"
                                                                    class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition-all"
                                                                    min="1" placeholder="Qty" disabled required
                                                                    oninput="this.value = this.value > this.max ? this.max : Math.abs(this.value)">
                                                                <span class="text-xs text-gray-500"
                                                                    id="quantity-help-{{ $patient->id }}"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div class="flex justify-end gap-3 mt-6">
                                                        <button type="button"
                                                            class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 focus:ring focus:ring-gray-200 transition-all"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="px-6 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 focus:ring focus:ring-green-200 transition-all">
                                                            Save Prescription
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="overflow-hidden border-0 shadow-lg modal-content rounded-xl">
                <div class="p-0 modal-body">
                    <form id="addPatientForm" action="{{ route('patients.store') }}" method="POST" class="p-6">
                        @csrf
                        <!-- Add alert for validation errors -->
                        <div class="mb-4 alert alert-danger d-none" id="addErrorAlert"></div>

                        <!-- Form Title -->
                        <div class="mb-6 text-center">
                            <h5 class="text-xl font-semibold text-gray-900">New Patient</h5>
                            <p class="text-sm text-gray-500">Enter patient information below</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Personal Info -->
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <div class="flex"><x-input-label value="First Name " /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="text" name="firstName" id="firstName"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="First Name" required>
                                </div>
                                <div>
                                    <x-input-label class="mb-1" value="Middle Name " />
                                    <input type="text" name="middleName" id="middleName"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Middle Name">
                                </div>
                                <div>
                                    <div class="flex"><x-input-label value="Last Name " /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="text" name="lastName" id="lastName"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="flex"><x-input-label value="Sex " /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <select name="sex"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        required>
                                        <option value="" selected>Select sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <div class="flex"><x-input-label value="Contact Number " /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="tel" name="contactDetails"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Contact Number" pattern="[0-9]{11}"
                                        title="Please enter a valid 11-digit phone number" required>
                                </div>
                            </div>

                            <!-- Classification -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="flex"><x-input-label value="Patient Type" /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <select name="patientType"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        required>
                                        <option value="" selected>Select patient type</option>
                                        <option value="Student">Student</option>
                                        <option value="Faculty">Faculty</option>
                                        <option value="Admin">Administrative</option>
                                        <option value="Visitor">Visitor</option>
                                        <option value="Dependent">Dependent</option>
                                    </select>
                                </div>
                                <div>
                                    <div class="flex"><x-input-label value="Year/Course/Dept" /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="text" name="year_course_dept"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Year/Course/Dept">
                                </div>
                                <div class="col-span-2">
                                    <div class="flex"><x-input-label value="Student Number" /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="text" name="student_number"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Enter student number">
                                </div>
                            </div>

                            <!-- Medical Info -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="flex"><x-input-label value="Patient Status" /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <input type="text" name="patient_status"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        placeholder="Enter patient status" required>
                                </div>
                                <div>
                                    <div class="flex"><x-input-label value="Physician" /><span
                                            class="ml-1 text-red-500">*</span></div>
                                    <select name="physician_id"
                                        class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                        required>
                                        <option value="" selected>Select a physician</option>
                                        @foreach ($physicians ?? [] as $physician)
                                            <option value="{{ $physician->id }}">
                                                {{ $physician->first_name }} {{ $physician->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <button type="button" id="savePatientBtn" disabled
                                    class="flex-1 px-6 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-lg
                                hover:bg-green-700 focus:ring focus:ring-red-200 transition-all">
                                    <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                                    Save Patient
                                </button>
                                <button type="button"
                                    class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg
                                hover:bg-gray-200 focus:ring focus:ring-gray-200 transition-all"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="similarPatientsModal" tabindex="-1" role="dialog" aria-labelledby="similarPatientsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="similarPatientsModalLabel">Similar Patients Found</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                The following similar patients were found in the database:
                </div>
                <div class="patient-list"></div>
                <p class="mt-3">Are you sure you want to add this patient anyway?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelAddPatient">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddPatient">Add Anyway</button>
            </div>
            </div>
        </div>
    </div> --}}

    @foreach ($patients as $patient)
        <div class="modal fade" id="viewPatient-{{ $patient->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="overflow-hidden border-0 shadow-lg modal-content rounded-xl">
                    <div class="p-0 modal-body">
                        <form id="patientForm-{{ $patient->id }}" action="{{ route('patients.update', $patient->id) }}"
                            method="POST" class="p-6">
                            @csrf
                            @method('PUT')

                            <!-- Form Title -->
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h5 class="text-xl font-semibold text-gray-900">Patient Information</h5>
                                    <p class="text-sm text-gray-500">View or modify patient details</p>
                                </div>
                                <button type="button"
                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-lg
                                hover:bg-yellow-200 focus:ring focus:ring-yellow-200 transition-all"
                                    onClick="toggleEdit({{ $patient->id }})">
                                    <i class="fas fa-edit me-1"></i>
                                    <span>Edit</span>
                                </button>
                            </div>

                            <!-- Add alert for validation errors -->
                            <div class="mb-4 alert alert-danger d-none" id="errorAlert-{{ $patient->id }}"></div>

                            <div class="space-y-4">
                                <!-- Personal Info -->
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <div class="flex"><x-input-label value="First Name" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="text" name="firstName"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->firstName }}" placeholder="First Name" disabled required>
                                    </div>
                                    <div>
                                        <div class="flex mb-1"><x-input-label value="Middle Name" /></div>
                                        <input type="text" name="middleName"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->middleName }}" placeholder="Middle Name" disabled>
                                    </div>
                                    <div>
                                        <div class="flex"><x-input-label value="Last Name" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="text" name="lastName"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->lastName }}" placeholder="Last Name" disabled required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex"><x-input-label value="Sex" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <select name="sex"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            disabled required>
                                            <option value="Male" {{ $patient->sex == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $patient->sex == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="flex"><x-input-label value="Contact Number" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="tel" name="contactDetails"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->contactDetails }}" placeholder="Contact Number *"
                                            disabled required>
                                    </div>
                                </div>

                                <!-- Classification -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex"><x-input-label value="Patient Type" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <select name="patientType"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            disabled required>
                                            <option value="Student"
                                                {{ $patient->patientType == 'Student' ? 'selected' : '' }}>Student</option>
                                            <option value="Faculty"
                                                {{ $patient->patientType == 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                            <option value="Admin"
                                                {{ $patient->patientType == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Visitor"
                                                {{ $patient->patientType == 'Visitor' ? 'selected' : '' }}>Visitor</option>
                                            <option value="Dependent"
                                                {{ $patient->patientType == 'Dependent' ? 'selected' : '' }}>Dependent
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="flex"><x-input-label value="Year/Course/Dept" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="text" name="year_course_dept"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->year_course_dept }}" placeholder="Year/Course/Dept"
                                            disabled>
                                    </div>
                                    <div class="col-span-2">
                                        <div class="flex"><x-input-label value="Student Number" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="text" name="student_number"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            value="{{ $patient->student_number }}" placeholder="Student Number" disabled>
                                    </div>
                                </div>

                                <!-- Medical Info -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex"><x-input-label value="Patient Status" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <input type="text" name="patient_status"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            placeholder="Patient Status *" value="{{ $patient->patient_status }}"
                                            disabled required>
                                    </div>
                                    <div>
                                        <div class="flex"><x-input-label value="Physician" /><span
                                                class="ml-1 text-red-500">*</span></div>
                                        <select name="physician_id"
                                            class="w-full px-2 py-2.5 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            disabled>
                                            @foreach ($physicians ?? [] as $physician)
                                                <option value="{{ $physician->id }}"
                                                    {{ $patient->physician_id == $physician->id ? 'selected' : '' }}>
                                                    {{ $physician->first_name }} {{ $physician->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit"
                                        class="flex-1 px-6 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-lg
                                    hover:bg-green-700 focus:ring focus:ring-red-200 transition-all"
                                        disabled>
                                        <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                                        Save Changes
                                    </button>
                                    <button type="button"
                                        class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg
                                    hover:bg-gray-200 focus:ring focus:ring-gray-200 transition-all"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
    <style>
        .content-wrapper {
            margin-left: 16rem;
            margin-top: 4rem;
            min-height: calc(100vh - 4rem);
            background-color: #f1f5f9;
        }

        @media (max-width: 640px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }
            
            #prescriptionPrintModal,
            #prescriptionPrintModal * {
                visibility: visible;
            }
            
            #prescriptionPrintModal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: white;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .prescription-form {
                border: none;
                box-shadow: none;
                font-size: 65%; 
            }
        }
        
        .prescription-form {
            font-family: Arial, sans-serif;
            width: 8.5in;
            max-width: 100%;
            margin: 0 auto;
            padding: 0.5in;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background: white;
            position: relative;
            font-size: 80%; 
        }
        
        .prescription-control-section {
            top: 0.3in;
            right: 0.5in;
            bottom: 0.5in;
            text-align: right;
            font-size: 80%;
        }
        
        .control-number-box {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-bottom: 0.4in;
        }
        
        .control-number-row {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .control-number-input {
            border: none;
            border-bottom: 1px solid #000;
            background: transparent;
            margin-left: 0.1in;
            width: 1.5in;
            text-align: center;
            font-size: 90%;
        }
        
        .prescription-header {
            text-align: center;
            margin-bottom: 0.5in;
        }
        
        .prescription-header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .prescription-header h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .prescription-header p {
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .prescription-body {
            margin-bottom: 0.5in;
        }
        
        .prescription-body .form-group {
            margin-bottom: 15px;
        }
        
        .prescription-body label {
            font-weight: bold;
            margin-right: 10px;
        }
        
        .prescription-body .value {
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            min-width: 200px;
            display: inline-block;
        }
        .prescription-footer {
            margin-top: 1in;
            text-align: right;
        }
        
        .rx-symbol {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('scripts')
    <script>
        // send an AJAX request to check for duplicate patients
        $(document).ready(function() {
            let formSubmitting = false;

            // Reload the page when the modal is closed (to update the table)
            $('#addPatientModal').on('hidden.bs.modal', function () {
                window.location.reload();
            });

            // Click handler for the Save Patient button
            $('#savePatientBtn').on('click', function(e) {
                e.preventDefault();

                if (formSubmitting) {
                    return;
                }

                // Reference the form and clear any previous error
                const form = $('#addPatientForm');
                $('#addErrorAlert').addClass('d-none').html('');

                // Retrieve trimmed values from input fields.
                const firstName  = form.find('input[name="firstName"]').val().trim();
                const middleName = form.find('input[name="middleName"]').val().trim();
                const lastName   = form.find('input[name="lastName"]').val().trim();

                // First, perform duplicate check via the check-similar route.
                $.ajax({
                    url: "{{ route('patients.check-similar') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        firstName: firstName,
                        middleName: middleName,
                        lastName: lastName
                    },
                    success: function(response) {
                        console.log("Duplicate check response:", response);
                        if (response.similarFound && response.similarPatients.length > 0) {
                            console.log("Duplicate detected, preventing submission.");
                            // Show error alert at the top.
                            $('#addErrorAlert')
                                .html('A patient with this name already exists. Please check before proceeding.')
                                .removeClass('d-none')
                                .removeClass('alert-success')
                                .addClass('alert alert-danger');
                            // Disable the Save button
                            $('#savePatientBtn')
                                .prop('disabled', true)
                            formSubmitting = false;
                            return; // Stop further processing
                        } else {
                            formSubmitting = true;
                            // Proceed to save the patient via the store route.
                            $.ajax({
                                url: form.attr('action'),
                                type: form.attr('method'),
                                data: form.serialize(),
                                success: function(resp) {
                                    $('#addErrorAlert')
                                        .html('Patient added successfully.')
                                        .removeClass('d-none')
                                        .removeClass('alert-danger')
                                        .addClass('alert alert-success');
                                    // Close the modal and reset the form.
                                    $('#addPatientModal').modal('hide');
                                    form.trigger('reset');
                                    // Re-enable the Save button (restore green button)
                                    $('#savePatientBtn')
                                        .prop('disabled', false)
                                    formSubmitting = false;
                                },
                                error: function(xhr, status, error) {
                                    // If the server returns a 422, try to extract the JSON message.
                                    let msg = error;
                                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.message) {
                                        msg = xhr.responseJSON.message;
                                    }
                                    $('#addErrorAlert')
                                        .html('Error while saving patient: ' + msg)
                                        .removeClass('d-none')
                                        .removeClass('alert-success')
                                        .addClass('alert alert-danger');
                                    formSubmitting = false;
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#addErrorAlert')
                            .html('Error while checking duplicates: ' + error)
                            .removeClass('d-none')
                            .removeClass('alert-success')
                            .addClass('alert alert-danger');
                        formSubmitting = false;
                    }
                });
            });

            // When any name field is modified, clear error messages and re-enable the Save button.
            $('#firstName, #middleName, #lastName').on('input', function() {
                $('#addErrorAlert').addClass('d-none').html('');
                $('#savePatientBtn')
                    .prop('disabled', false)
            });
        });

        function toggleEdit(patientID) {
            const patientForm = document.getElementById('patientForm-' + patientID);
            const patientInputs = patientForm.querySelectorAll('input:not([type="hidden"]), select, textarea');
            const editButton = patientForm.querySelector('button[onClick*="toggleEdit"]');
            const submitBtn = patientForm.querySelector('button[type="submit"]');
            const errorAlert = document.getElementById('errorAlert-' + patientID);

            patientInputs.forEach(input => {
                input.disabled = !input.disabled;
                if (!input.disabled) {
                    input.classList.remove('is-invalid');
                }
            });

            errorAlert.classList.add('d-none');
            errorAlert.textContent = '';

            const buttonIcon = editButton.querySelector('i');
            const buttonText = editButton.querySelector('span');

            if (buttonText.textContent === 'Edit') {
                buttonText.textContent = 'Cancel';
                buttonIcon.classList.remove('fa-edit');
                buttonIcon.classList.add('fa-times');
                editButton.classList.remove('bg-yellow-100', 'text-yellow-700');
                editButton.classList.add('bg-gray-100', 'text-gray-700');
                submitBtn.disabled = false; // Enable submit button
            } else {
                buttonText.textContent = 'Edit';
                buttonIcon.classList.remove('fa-times');
                buttonIcon.classList.add('fa-edit');
                editButton.classList.remove('bg-gray-100', 'text-gray-700');
                editButton.classList.add('bg-yellow-100', 'text-yellow-700');
                submitBtn.disabled = true; 
                patientForm.reset();
            }
        }

        // Add prescription print modal to the DOM
        document.body.insertAdjacentHTML('beforeend', `
            <div id="prescriptionPrintModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex min-h-screen text-center sm:block">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                    <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <div class="prescription-form">
                                <div class="prescription-control-section no-print">
                                    <div class="control-number-box">
                                        <div class="control-number-row">
                                            <span>Control No:</span>
                                            <input type="text" id="print-control-number" class="control-number-input" value="PUP-MEPF-6-MEDS-001">
                                        </div>
                                        <div class="control-number-row">
                                            <span>Rev.</span>
                                            <input type="text" id="print-revision-number" class="control-number-input" value="0">
                                        </div>
                                        <div class="control-number-row">
                                            <input type="text" id="print-revision-date" class="control-number-input" value="May 15, 2018">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="prescription-header">
                                    <h1>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                                    <h2>Manila</h2>
                                </div>
                                <div class="prescription-body">
                                    <div class="form-group">
                                        <label>Patient Name:</label>
                                        <span class="value" id="print-patient-name"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Age:</label>
                                        <input type="text" id="print-age">
                                        <label style="margin-left: 10px;">Date:</label>
                                        <input type="text" id="print-date">
                                    </div>
                                    <div class="rx-symbol">Rx</div>
                                    <div class="medication" id="print-medication">
                                        <!-- Will be populated with medication details -->
                                    </div>
                                </div>
                                <div class="prescription-footer">
                                    <div class="doctor-info" id="print-doctor-info">
                                        <span id="print-doctor-name"></span><span> M.D.</span>
                                        <p>Lic No. <span id="print-license-number"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-4 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse no-print">
                            <button type="button" onclick="window.print()" aria-label="Print Prescription" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="mr-2 fas fa-print" aria-hidden="true"></i> Print
                            </button>
                            <button type="button" onclick="closePrintModal()" aria-label="Close Modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="mr-2 fas fa-times" aria-hidden="true"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);

        function printPrescription(prescriptionId, patientName, patientSex, patientAge, medicineName, quantity, unit, date, doctorName, licenseNumber) {
            // Close the prescription list modal first
            // Find the currently open modal and close it
            const openModalId = document.querySelector('.modal.show')?.id;
            if (openModalId) {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById(openModalId));
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
            
            // Get today's date in the format: Apr 20, 2025
            const today = new Date().toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            
            // Fill in the prescription form
            document.getElementById('print-patient-name').textContent = patientName;
            document.getElementById('print-age').value = patientAge ? patientAge : '';
            document.getElementById('print-date').value = today;
            
            // Set medication details
            document.getElementById('print-medication').innerHTML = `
                <p style="margin-bottom: 10px;"><strong>${medicineName}</strong></p>
                <p style="margin-left: 20px;">Quantity: ${quantity} ${unit}</p>
            `;
            
            // Set doctor info
            document.getElementById('print-doctor-name').textContent = doctorName;
            document.getElementById('print-license-number').textContent = licenseNumber;
            
            // Show the print modal after a short delay to ensure the previous modal is fully closed
            setTimeout(() => {
                document.getElementById('prescriptionPrintModal').classList.remove('hidden');
            }, 150);
        }
        
        function closePrintModal() {
            document.getElementById('prescriptionPrintModal').classList.add('hidden');
        }

        // Form submission handlers
        document.querySelectorAll('[id^="patientForm-"]').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const spinner = submitBtn.querySelector('.spinner-border');
                const errorAlert = document.getElementById('errorAlert-' + this.id.split('-')[1]);
                const modal = this.closest('.modal');

                // Reset previous errors
                errorAlert.classList.add('d-none');
                errorAlert.innerHTML = '';

                // Remove previous validation classes
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });

                // Show loading state
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');

                try {
                    const formData = new FormData(this);

                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();
                        console.log('Response data:', data); 

                        if (data.success) {
                            bootstrap.Modal.getInstance(modal).hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            errorAlert.classList.remove('d-none');

                            const errorHeader = document.createElement('div');
                            errorHeader.className = 'font-medium text-red-600 mb-2';
                            errorHeader.textContent = data.message ||
                                'Please correct the following errors:';
                            errorAlert.appendChild(errorHeader);

                            if (data.errors) {
                                const errorList = document.createElement('ul');
                                errorList.className = 'list-disc pl-5 text-sm';

                                Object.entries(data.errors).forEach(([field, errors]) => {
                                    const input = this.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');

                                        const feedback = document.createElement('div');
                                        feedback.className = 'text-red-500 text-xs mt-1';
                                        feedback.textContent = errors[0];
                                        input.parentNode.appendChild(feedback);
                                    }
                                    const li = document.createElement('li');
                                    li.className = 'text-red-500';
                                    li.textContent = errors[0];
                                    errorList.appendChild(li);
                                });

                                errorAlert.appendChild(errorList);
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Form Error',
                                text: data.message || 'Please check the form for errors.',
                                confirmButtonColor: '#9F1239'
                            });
                        }
                    } else {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while saving changes.',
                        confirmButtonColor: '#9F1239'
                    });
                } finally {
                    submitBtn.disabled = false;
                    spinner.classList.add('d-none');
                }
            });
        });

        document.getElementById('addPatientForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const spinner = submitBtn.querySelector('.spinner-border');
            const errorAlert = document.getElementById('addErrorAlert');
            const modal = this.closest('.modal');

            errorAlert.classList.add('d-none');
            errorAlert.innerHTML = '';

            this.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            this.querySelectorAll('.text-red-500').forEach(el => {
                el.remove();
            });

            submitBtn.disabled = true;
            spinner.classList.remove('d-none');

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    bootstrap.Modal.getInstance(modal).hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Patient added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    errorAlert.classList.remove('d-none');

                    const errorHeader = document.createElement('div');
                    errorHeader.className = 'font-medium text-red-600 mb-2';
                    errorHeader.textContent = data.message || 'Please correct the following errors:';
                    errorAlert.appendChild(errorHeader);

                    if (data.errors) {
                        const errorList = document.createElement('ul');
                        errorList.className = 'list-disc pl-5 text-sm';

                        Object.entries(data.errors).forEach(([field, errors]) => {
                            const input = this.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                input.classList.add('border-red-500');
                                const feedback = document.createElement('div');
                                feedback.className = 'text-red-500 text-xs mt-1';
                                feedback.textContent = errors[0];
                                input.parentNode.appendChild(feedback);
                            }

                            const li = document.createElement('li');
                            li.className = 'text-red-500';
                            li.textContent = errors[0];
                            errorList.appendChild(li);
                        });

                        errorAlert.appendChild(errorList);
                    }

                    modal.scrollTop = 0;
                }
            } catch (error) {
                console.error('Error:', error);
                errorAlert.classList.remove('d-none');
                errorAlert.innerHTML =
                    `<div class="font-medium text-red-600">An error occurred. Please try again later.</div>`;

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while adding the patient.',
                    confirmButtonColor: '#9F1239'
                });
            } finally {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });

        function toggleStudentNumberField(selectElement, formType) {
            const formId = formType === 'add' ? 'addPatientForm' : selectElement.closest('form').id;
            const studentNumberInput = document.querySelector(`#${formId} [name="student_number"]`);
            const studentNumberDiv = studentNumberInput.closest('.col-span-2');

            if (selectElement.value === 'Student') {
                studentNumberDiv.classList.remove('d-none');
                studentNumberInput.required = true;
                if (studentNumberInput.dataset.tempValue) {
                    studentNumberInput.value = studentNumberInput.dataset.tempValue;
                }
            } else {
                studentNumberInput.dataset.tempValue = studentNumberInput.value;
                studentNumberDiv.classList.add('d-none');
                studentNumberInput.required = false;
                studentNumberInput.value = '';
            }
        }

        function confirmDelete(form) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9F1239',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const patientRows = document.querySelectorAll('tr[data-patient-type]');

            function filterPatients(filterValue) {
                patientRows.forEach(row => {
                    if (filterValue === 'all' || row.dataset.patientType === filterValue) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-gray-800', 'bg-blue-50');
                        btn.classList.add('border-gray-300', 'text-gray-500');
                    });
                    button.classList.remove('border-gray-300', 'text-gray-500');
                    button.classList.add('border-blue-500', 'text-gray-800', 'bg-blue-50');
                    filterPatients(button.dataset.filter);
                });
            });

            const prescriptionForms = document.querySelectorAll('form[action*="prescriptions"]');
            prescriptionForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handlePrescriptionSubmit(form);
                });
            });

            const medicineSelects = document.querySelectorAll('select[id^="medicine-select-"]');
            medicineSelects.forEach(select => {
                select.addEventListener('change', function() {
                    handleMedicineSelection(this);
                });
            });

            document.querySelector('#addPatientForm [name="patientType"]')?.addEventListener('change', function() {
                toggleStudentNumberField(this, 'add');
            });

            document.querySelectorAll('[id^="patientForm-"] [name="patientType"]').forEach(select => {
                select.addEventListener('change', function() {
                    toggleStudentNumberField(this, 'edit');
                });
            });
        });

        async function handlePrescriptionSubmit(form) {
            try {
                form.querySelectorAll('.text-red-500').forEach(el => {
                    el.remove();
                });

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    if (data.medicine) {
                        updateMedicineQuantities(
                            data.medicine.id,
                            data.medicine.remaining_quantity,
                            data.medicine.unit
                        );
                    }

                    const patientId = formData.get('patient_id');
                    bootstrap.Modal.getInstance(document.querySelector(`#prescriptionModal-${patientId}`)).hide();

                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#dc2626'
                    }).then(() => {
                        const prescriptionsList = document.querySelector(
                            `#prescriptionListModal-${patientId} .overflow-y-auto`);
                        if (prescriptionsList) {
                            const newPrescription = createPrescriptionElement(data.prescription);
                            prescriptionsList.insertAdjacentHTML('afterbegin', newPrescription);
                        }

                        form.reset();
                    });
                } else {
                    let errorMessage = data.message || 'An error occurred while creating the prescription.';

                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, errors]) => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('border-red-500');

                                const feedback = document.createElement('div');
                                feedback.className = 'text-red-500 text-xs mt-1';
                                feedback.textContent = errors[0];
                                input.parentNode.appendChild(feedback);
                            }
                        });
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while creating the prescription. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626'
                });
            }
        }

        function updateMedicineQuantities(medicineId, newQuantity, unit) {
            const medicineSelects = document.querySelectorAll('select[id^="medicine-select-"]');

            medicineSelects.forEach(select => {
                const option = select.querySelector(`option[value="${medicineId}"]`);
                if (option) {
                    const medicineName = option.textContent.split('(')[0].trim();
                    option.textContent = `${medicineName} (Available: ${newQuantity} ${unit})`;
                    if (option.selected) {
                        const patientId = select.id.split('-').pop();
                        const quantityInput = document.getElementById(`quantity-${patientId}`);
                        if (quantityInput) {
                            quantityInput.max = newQuantity;
                            if (parseInt(quantityInput.value) > newQuantity) {
                                quantityInput.value = newQuantity;
                            }
                        }
                    }
                }
            });
        }

        function handleMedicineSelection(select) {
            const patientId = select.id.split('-').pop();
            const quantityInput = document.getElementById(`quantity-${patientId}`);
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                const availableQty = selectedOption.text.match(/Available: (\d+)/);
                if (availableQty && availableQty[1]) {
                    quantityInput.max = availableQty[1];
                    quantityInput.value = '';
                    quantityInput.disabled = false;
                }
            } else {
                quantityInput.disabled = true;
                quantityInput.value = '';
                quantityInput.removeAttribute('max');
            }
        }

        function createPrescriptionElement(prescription) {
            return `
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm font-medium text-gray-900">
                            ${prescription.medicine.medicine_name}
                        </span>
                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                            ${prescription.quantity} units
                        </span>
                    </div>
                    <span class="text-xs text-gray-500">
                        ${new Date(prescription.created_at).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        })}
                    </span>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Available: ${prescription.medicine.remaining_quantity} ${prescription.medicine.unit}
                    </p>
                </div>
            </div>
        </div>
    `;
        }
    </script>
@endsection