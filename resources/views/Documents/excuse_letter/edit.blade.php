@extends('layouts.app-layout')

@section('title', 'Edit Excuse Letter')

@section('content')
<style>
    /* Adjusting for print */
    @media print {
        @page {
            size: A4; /* O palitan ng 'Letter' kung Letter size ang gamit */
            margin: 0; /* Tanggalin ang margin */
        }

        body, html {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            overflow: hidden !important;
        }

        .page {
            margin: 0;
            padding: 0;
            position: relative;
            top: -130px; /* Alisin ang offset */
        }
            body {
            font-family: Arial;
            font-size: 13px;
        }
        .container {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
      }
    }
</style>

    <div class="flex space-x-10 justify-between mb-5 print:hidden">
        <button class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400 flex items-center space-x-2"
            onclick="goBack()" aria-label="Go Back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path
                    d="M3.82843 6.9999H16V8.9999H3.82843L9.1924 14.3638L7.7782 15.778L0 7.9999L7.7782 0.22168L9.1924 1.63589L3.82843 6.9999Z"
                    fill="black" />
            </svg>
            <span>Back</span>
        </button>

        <div>
            <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 mr-2" onclick="openEditForm()"
                aria-label="Edit Form">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                    <path
                        d="M3.41421 13.9706L13.5563 3.82843L12.1421 2.41421L2 12.5564V13.9706H3.41421ZM4.24264 15.9706H0V11.7279L11.435 0.29289C11.8256 -0.09763 12.4587 -0.09763 12.8492 0.29289L15.6777 3.12132C16.0682 3.51184 16.0682 4.14501 15.6777 4.53553L4.24264 15.9706ZM0 17.9706H18V19.9706H0V17.9706Z"
                        fill="white" />
                </svg>
            </button>
            <button class="px-4 py-2 bg-[#7A0019] text-white rounded-md hover:bg-opacity-80 mr-5" onclick="printWaiver()"
                aria-label="Print the form">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none">
                    <path
                        d="M18.75 0.000488281C19.4404 0.000488281 20 0.448208 20 1.00049V5.00049H23.75C24.4404 5.00049 25 5.44821 25 6.00049V16.0005C25 16.5528 24.4404 17.0005 23.75 17.0005H20V19.0005C20 19.5528 19.4404 20.0005 18.75 20.0005H6.25C5.55965 20.0005 5 19.5528 5 19.0005V17.0005H1.25C0.55965 17.0005 0 16.5528 0 16.0005V6.00049C0 5.44821 0.55965 5.00049 1.25 5.00049H5V1.00049C5 0.448208 5.55965 0.000488281 6.25 0.000488281H18.75ZM17.5 15.0005H7.5V18.0005H17.5V15.0005ZM22.5 7.00049H2.5V15.0005H5V14.0005C5 13.4482 5.55965 13.0005 6.25 13.0005H18.75C19.4404 13.0005 20 13.4482 20 14.0005V15.0005H22.5V7.00049ZM7.5 8.00049V10.0005H3.75V8.00049H7.5ZM17.5 2.00049H7.5V5.00049H17.5V2.00049Z"
                        fill="white" />
                </svg>
            </button>
        </div>
    </div>

    <div class="container mx-auto bg-white md:py-10 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
        <div class="page">
            <!-- Document Content -->
            <div class="container">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $associatedDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $associatedDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($associatedDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center justify-center mb-10">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="University logo" class="w-28 mb-5">
                    </div>
                    <div class="text-center" style="font-family: 'Times New Roman', serif;">

                        <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                        <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                        <p class="text-sm mb-5">Quezon City</p>
                        <h2 class="text-xl font-semibold">EXCUSE LETTER</h2>
                    </div>
                </div>

                <!-- Body Content -->
                <div id="letterOutput" class="md:px-10" style="font-size: 16px">
                    <div class="mb-10 text-right">
                        <label class="font-medium">Date: </label>
                        <span id="letterDate" class="underline"> {{ \Carbon\Carbon::parse($associatedDocument->date)->format('F j, Y') ?? '__________' }} </span>

                    </div>
                    <div class="space-y-4">
                        <p class="text-lg">
                            Dear <span id="recipientName"
                                class="underline">{{ $associatedDocument->recipient ?? '__________' }}</span>,
                        </p>
                        <p class="text-lg">
                            I, <span id="studentName" class="underline">{{ $associatedDocument->patient_name ?? '__________' }}</span>, a student of the
                            <span id="department" class="underline">{{ $associatedDocument->department ?? '__________' }}</span> Department, would
                            like to inform you that I was unable to attend class on <span
                                id="absenceDate" class="underline">{{ \Carbon\Carbon::parse($associatedDocument->excuse_for)->format('F j, Y') ?? '__________' }}</span> due to <span
                                id="reasons" class="underline">{{ $associatedDocument->cause ?? '__________' }}</span>.
                        </p>
                        <p class="text-lg">
                            Thank you for your consideration.
                        </p>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="flex justify-end mt-10">
                    <div class="w-11/30 text-left">
                        <p class="font-medium">Sincerely,</p>
                        <p id="studentSignature" class="underline">{{ $associatedDocument->patient_name ?? '__________' }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-10">
                    <div class="text-left">
                        <p id="physicianSignature" class="underline">{{ $associatedDocument->doctorName ?? '__________' }}
                            <label class="font-medium">M.D. </label>
                        </p>
                        <p class="text-center font-medium">Clinic Physician</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- Success Notification -->
                <div class="container mx-auto bg-white md:py-20 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
                    <!-- Success Notification -->
                    <div id="successMessage"
                        class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-10">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
                            <div
                                class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <!-- Green Checkmark Icon -->
                                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-lg font-semibold">Successfully Edited!</p>
                        </div>
                    </div>
                </div>
                @include('Documents.excuse_letter.edit-form')
                    <!-- Modal -->
                    <div id="editFormModal"
                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                        <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative"
                            style="max-height: 80%; overflow-y: auto;">
                            <!-- Close Button in Top-Right -->
                            <span
                                class="close absolute top-2.5 right-2.5 text-red-500 text-2xl cursor-pointer hover:text-red-700"
                                onclick="closeEditForm()">&times;</span>

                            <!-- Modal Title -->
                            <h3 class="text-xl font-semibold mb-4 text-gray-700">Edit Excuse Letter</h3>

                            <!-- Form Container -->
                            <div id="formContainer" class="space-y-4">
                                <form action="{{ route('documents.excuse_letter.update', $document->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- This ensures the method is PUT for updating -->
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Date:</label>
                                        <input type="date" id="date" class="w-full border rounded-md px-3 py-2" name="date"
                                            value="{{ old('date', $associatedDocument->date ?? '') }}" required>
                                        <div id="dateError" class="hidden text-red-500">Please enter the date of absence.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Dear (Recipient):</label>
                                        <input type="text" id="recipient" name="recipient"
                                            class="w-full border rounded-md px-3 py-2" placeholder="Enter recipient's name"
                                            value="{{ old('recipient', $associatedDocument->recipient ?? '') }}" required>
                                        <div id="nameError" class="hidden text-red-500">Please enter the recipient's name.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Student Name:</label>
                                        <input type="text" id="patient_name" name="patient_name"
                                            class="w-full border rounded-md px-3 py-2" placeholder="Enter student name"
                                            value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Department:</label>
                                        <input type="text" id="departmentInput" name="department"
                                            class="w-full border rounded-md px-3 py-2" placeholder="Enter department"
                                            value="{{ old('department', $associatedDocument->department ?? '') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Date of Absence:</label>
                                        <input type="date" id="excuse_for" name="excuse_for"
                                            class="w-full border rounded-md px-3 py-2" value="{{ old('excuse_for', $associatedDocument->excuse_for ?? '') }}" required>
                                        <div id="dateError" class="hidden text-red-500">Please enter the date of absence.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Reason for Absence:</label>
                                        <input type="text" id="cause" name="cause"
                                            class="w-full border rounded-md px-3 py-2" placeholder="Enter reason for absence"
                                            value="{{ old('cause', $associatedDocument->cause ?? '') }}" required>
                                        <div id="reasonError" class="hidden text-red-500">Please enter the reason for absence.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-gray-600 font-medium mb-1">Physician's Name:</label>
                                        <input type="text" id="doctorName" name="doctorName"
                                            class="w-full border rounded-md px-3 py-2" placeholder="Enter physician's name"
                                            value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}" required>
                                        <div id="licenseNoError" class="hidden text-red-500">Please enter the physician's name.</div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-center space-x-4 mt-6">
                                        <button onclick="saveEdits()" class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-20 rounded-md">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

@endsection

@push('scripts')
    <script>
        function goBack() {
            window.location.href = "{{ route('documents.index') }}";
        }

        function printWaiver() {
            window.print();
        }
        // Function to open the modal
        function openEditForm() {
            // document.getElementById('editFormModal').classList.remove('hidden');

            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
        }

        // Function to close the modal
        function closeEditForm() {
            // document.getElementById('editFormModal').classList.add('hidden');

            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        function saveEdits() {
            const date = document.getElementById('date').value;
            const recipientName = document.getElementById('recipient').value;
            const studentName = document.getElementById('patient_name').value;
            const department = document.getElementById('departmentInput').value;
            const absenceDate = document.getElementById('excuse_for').value;
            const reason = document.getElementById('cause').value;
            const physicianName = document.getElementById('doctorName').value;

            // Validate inputs
            let isValid = true;

            // Check if fields are filled
            if (!recipientName.trim()) {
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('nameError').classList.add('hidden');
            }

            if (!absenceDate) {
                document.getElementById('dateError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('dateError').classList.add('hidden');
            }

            if (!reason.trim()) {
                document.getElementById('reasonError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('reasonError').classList.add('hidden');
            }

            if (!physicianName.trim()) {
                document.getElementById('licenseNoError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('licenseNoError').classList.add('hidden');
            }

            console.log(isValid);

            // If all fields are valid, update the placeholders in the letter
            if (isValid) {
                Swal.fire({
                    title: "Success!",
                    text: 'Document has been saved successfully.',
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: 'Failed to save the document.',
                    icon: "error"
                });
            }
        }
    </script>
@endpush
