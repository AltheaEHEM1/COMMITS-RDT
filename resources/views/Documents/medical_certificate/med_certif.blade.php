@extends('layouts.app-layout')

@section('title', 'Medical Certificate')

@section('content')
    <!-- Buttons (Optional for print view, you can hide them when printing) -->
    <div class="flex space-x-10 justify-between mb-5">
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
            <button class="px-4 py-2 bg-[#7A0019] text-white rounded-md hover:bg-[#7A0019] hover:bg-opacity-80 mr-5"
                onclick="printWaiver()" aria-label="Print the form">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none">
                    <path
                        d="M18.75 0.000488281C19.4404 0.000488281 20 0.448208 20 1.00049V5.00049H23.75C24.4404 5.00049 25 5.44821 25 6.00049V16.0005C25 16.5528 24.4404 17.0005 23.75 17.0005H20V19.0005C20 19.5528 19.4404 20.0005 18.75 20.0005H6.25C5.55965 20.0005 5 19.5528 5 19.0005V17.0005H1.25C0.55965 17.0005 0 16.5528 0 16.0005V6.00049C0 5.44821 0.55965 5.00049 1.25 5.00049H5V1.00049C5 0.448208 5.55965 0.000488281 6.25 0.000488281H18.75ZM17.5 15.0005H7.5V18.0005H17.5V15.0005ZM22.5 7.00049H2.5V15.0005H5V14.0005C5 13.4482 5.55965 13.0005 6.25 13.0005H18.75C19.4404 13.0005 20 13.4482 20 14.0005V15.0005H22.5V7.00049ZM7.5 8.00049V10.0005H3.75V8.00049H7.5ZM17.5 2.00049H7.5V5.00049H17.5V2.00049Z"
                        fill="white" />
                </svg>
            </button>
        </div>
    </div>

    <div class="container mx-auto bg-white md:py-20 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
        <div class="page">
            <!-- Document 2 (duplicate the structure as needed) -->
            <div class="container">
                <div class="flex items-center justify-center mb-5">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="Logo" class="w-28 mb-5">
                    </div>
                    <!-- Center-aligned text block with a serif font -->
                    <div class="text-center" style="font-family: 'Times New Roman', serif;">
                        <!-- Republic heading -->
                        <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                        <!-- University heading -->
                        <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                        <!-- Location -->
                        <p class="text-sm mb-5">Quezon City</p>
                        <!-- Medical clearance title -->
                        <h2 class="text-xl font-semibold">MEDICAL CERTIFICATE</h2>
                    </div>

                </div>

                <div class="text-right my-10 mb-8 font-Arial">
                    <span><span id="date-placeholder1" class="underline-offset-4">Date ___________________</span></span>
                </div>

                <div class="space-y-4 font-Arial mb-5">
                    <p>To Whom It May Concern:</p>
                    <p class="indent-8">
                        This is to clarify that <span id="name-placeholder1"
                            class="underline-offset-4">________________________</span>
                        has been treated/ is currently being treated for <span id="reason-placeholder1"
                            class="underline-offset-4">____________________</span>
                        from <span id="start-date-placeholder1" class="underline-offset-4">________________________</span>
                        to
                        <span id="end-date-placeholder1" class="underline-offset-4">________________________</span>.
                    </p>
                    <p class="indent-8">
                        This certification is issued upon his/her request for <span id="purpose-placeholder1"
                            class="underline-offset-4">________________________</span> purposes but not for medico-legal
                        reasons.
                    </p>
                </div>

                <div class="flex justify-end p-10">
                    <div class="w-11/30 text-left">
                        <p><span id="physician-name-placeholder1" class="underline-offset-4">____________________</span>
                            M.D.</p>
                        <p class="text-center">Clinic Physician</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Document 2 (duplicate the structure as needed) -->
        <div class="container2 mt-0">
            <div class="flex items-center justify-center mb-5">
                <div class="mr-5">
                    <img src="{{ asset('Logo_image/logopup.png') }}" alt="Logo" class="w-28 mb-5">
                </div>
                <!-- Center-aligned text block with a serif font -->
                <div class="text-center" style="font-family: 'Times New Roman', serif;">
                    <!-- Republic heading -->
                    <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                    <!-- University heading -->
                    <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                    <!-- Location -->
                    <p class="text-sm mb-5">Quezon City</p>
                    <!-- Medical clearance title -->
                    <h2 class="text-xl font-semibold">MEDICAL CERTIFICATE</h2>
                </div>

            </div>

            <div class="text-right my-10 mb-0 font-Arial">
                <span><span id="date-placeholder2" class="underline-offset-4">Date ____________________</span></span>
            </div>

            <div class="space-y-4 font-Arial mb-5">
                <p>To Whom It May Concern:</p>
                <p class="indent-8">
                    This is to clarify that <span id="name-placeholder2"
                        class="underline-offset-4">________________________</span>
                    has been treated/ is currently being treated for <span id="reason-placeholder2"
                        class="underline-offset-4">____________________</span>
                    from <span id="start-date-placeholder2" class="underline-offset-4">________________________</span>
                    to
                    <span id="end-date-placeholder2" class="underline-offset-4">________________________</span>.
                </p>
                <p class="indent-8">
                    This certification is issued upon his/her request for <span id="purpose-placeholder2"
                        class="underline-offset-4">________________________</span> purposes but not for medico-legal
                    reasons.
                </p>
            </div>

            <div class="flex justify-end p-10">
                <div class="w-11/30 text-left">
                    <p><span id="physician-name-placeholder2" class="underline-offset-4">____________________</span>
                        M.D.</p>
                    <p class="text-center">Clinic Physician</p>
                </div>
            </div>
        </div>


        <div id="editFormModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="modal-content1 bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
                <!-- Close Button in Top-Right -->
                <span class="close absolute top-2.5 right-2.5 text-red-500 text-2xl cursor-pointer hover:text-red-700"
                    onclick="closeEditForm()">&times;</span>

                <!-- Modal Title -->
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Edit Medical Certificate Form</h3>

                <!-- Form Container -->
                <div id="formContainer" class="space-y-4">
                    <!-- Date Field -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Date:</label>
                        <input type="date" id="dateInput"
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                    </div>

                    <!-- Patient Name Field -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Patient's Name:</label>
                        <input type="text" id="patientNameInput" class="w-full border rounded-md px-3 py-2"
                            placeholder="Enter patient's name" required>
                        <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                    </div>

                    <!-- Treated for -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Being Treated For:</label>
                        <input type="text" id="reasonInput" class="w-full border rounded-md px-3 py-2"
                            placeholder="Reason for treatment" required>
                        <span id="reasonError" class="text-red-500 text-sm hidden">Reason is required.</span>
                    </div>

                    <!-- Start Date -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Start Date Examination:</label>
                        <input type="date" id="startDateInput"
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <span id="startDateError" class="text-red-500 text-sm hidden">Start date is required.</span>
                    </div>

                    <!-- End Date -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">End Date Examination:</label>
                        <input type="date" id="endDateInput"
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <span id="endDateError" class="text-red-500 text-sm hidden">End date is required.</span>
                    </div>

                    <!-- Purpose -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Purpose of Certification:</label>
                        <input type="text" id="purposeInput" class="w-full border rounded-md px-3 py-2"
                            placeholder="Purpose" required>
                        <span id="purposeError" class="text-red-500 text-sm hidden">Purpose is required.</span>
                    </div>

                    <!-- Clinic Physician -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Clinic Physician Name:</label>
                        <input type="text" id="physicianInput" class="w-full border rounded-md px-3 py-2"
                            placeholder="Physician's name" required>
                    </div>

                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <button onclick="addForm()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Add Form
                    </button>
                    <button onclick="saveEdits()"
                        class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                        Save
                    </button>
                </div>
            </div>
        </div>
        <!-- Success Notification -->
        <div id="successMessage" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <!-- Green Checkmark Icon -->
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-lg font-semibold">Successfully Saved!</p>
            </div>
        </div>

        <script>
            // Variable to track the current form being edited
            let currentFormId = null;

            // Function to go back to the previous page
            function goBack() {
                window.history.back();
            }

            // Function to open the edit form modal
            function openEditForm(formId) {
                currentFormId = formId; // Track which form is being edited
                document.getElementById('editFormModal').classList.remove('hidden');
            }

            // Function to close the edit form modal
            function closeEditForm() {
                document.getElementById('editFormModal').classList.add('hidden');
            }

            // Function to add a new form (up to 2 forms)
            let formCount = 1; // Track the number of forms added

            function addForm() {
                if (formCount < 2) {
                    const formContainer = document.getElementById('formContainer');
                    const newFormGroup = document.createElement('div');
                    newFormGroup.classList.add('space-y-4');

                    newFormGroup.innerHTML = `
       <h2 class="text-xl font-semibold mb-4 text-gray-700">Form 2</h2>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="dateInput2">Date:</label>
<input type="date" id="dateInput2" class="w-full border rounded-md px-3 py-2" required>
<span id="dateError2" class="text-red-500 text-sm hidden">Date is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="patientNameInput2">Patient's Name:</label>
<input type="text" id="patientNameInput2" class="w-full border rounded-md px-3 py-2" placeholder="Enter patient's name" required>
<span id="nameError2" class="text-red-500 text-sm hidden">Name is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="reasonInput2">Being Treated For:</label>
<input type="text" id="reasonInput2" class="w-full border rounded-md px-3 py-2" placeholder="Reason for treatment" required>
<span id="reasonError2" class="text-red-500 text-sm hidden">Reason is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="startDateInput2">Start Date:</label>
<input type="date" id="startDateInput2" class="w-full border rounded-md px-3 py-2" required>
<span id="startDateError2" class="text-red-500 text-sm hidden">Start date is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="endDateInput2">End Date:</label>
<input type="date" id="endDateInput2" class="w-full border rounded-md px-3 py-2" required>
<span id="endDateError2" class="text-red-500 text-sm hidden">End date is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="purposeInput2">Purpose:</label>
<input type="text" id="purposeInput2" class="w-full border rounded-md px-3 py-2" placeholder="Purpose of visit" required>
<span id="purposeError2" class="text-red-500 text-sm hidden">Purpose is required.</span>
</div>

<div class="form-group">
<label class="block text-gray-600 font-medium mb-1" for="physicianInput2">Physician Name:</label>
<input type="text" id="physicianInput2" class="w-full border rounded-md px-3 py-2" placeholder="Physician's name" required>
<span id="physicianError2" class="text-red-500 text-sm hidden">Physician's name is required.</span>
</div>

    `;

                    formContainer.appendChild(newFormGroup);
                    formCount++;
                } else {
                    alert("You can only add 2 forms.");
                }
            }

            function saveEdits() {
                let isValid = true;

                // Define input and placeholder mapping for both forms
                const forms = {
                    1: {
                        date: 'dateInput',
                        patientName: 'patientNameInput',
                        reason: 'reasonInput',
                        startDate: 'startDateInput',
                        endDate: 'endDateInput',
                        purpose: 'purposeInput',
                        physicianName: 'physicianInput',
                        placeholders: {
                            date: 'date-placeholder1',
                            patientName: 'name-placeholder1',
                            reason: 'reason-placeholder1',
                            startDate: 'start-date-placeholder1',
                            endDate: 'end-date-placeholder1',
                            purpose: 'purpose-placeholder1',
                            physicianName: 'physician-name-placeholder1',
                        },
                        errors: {
                            date: 'dateError',
                            patientName: 'nameError',
                            reason: 'reasonError',
                            startDate: 'startDateError',
                            endDate: 'endDateError',
                            purpose: 'purposeError',
                        },
                    },
                    2: {
                        date: 'dateInput2',
                        patientName: 'patientNameInput2',
                        reason: 'reasonInput2',
                        startDate: 'startDateInput2',
                        endDate: 'endDateInput2',
                        purpose: 'purposeInput2',
                        physicianName: 'physicianInput2',
                        placeholders: {
                            date: 'date-placeholder2',
                            patientName: 'name-placeholder2',
                            reason: 'reason-placeholder2',
                            startDate: 'start-date-placeholder2',
                            endDate: 'end-date-placeholder2',
                            purpose: 'purpose-placeholder2',
                            physicianName: 'physician-name-placeholder2',
                        },
                        errors: {
                            date: 'dateError2',
                            patientName: 'nameError2',
                            reason: 'reasonError2',
                            startDate: 'startDateError2',
                            endDate: 'endDateError2',
                            purpose: 'purposeError2',
                        },
                    },
                };

                // Function to update placeholders with underline styling
                function updateWithUnderline(elementId, value) {
                    const element = document.getElementById(elementId);
                    if (element) {
                        element.style.textDecoration = "underline";
                        element.style.textUnderlineOffset = "4px"; // Adjust the offset for styling
                        element.innerText = value || "_____"; // Fallback to empty placeholder if no value
                    }
                }

                // Validate and process both forms if present
                Object.keys(forms).forEach((formId) => {
                    const form = forms[formId];
                    let formPresent = false;

                    // Check if the form exists by checking the first field
                    if (document.getElementById(form.date)) {
                        formPresent = true;
                    }

                    if (formPresent) {
                        // Validate inputs and update placeholders
                        for (const field in form.placeholders) {
                            const inputElement = document.getElementById(form[field]);
                            const errorElement = document.getElementById(form.errors[field]);

                            if (!inputElement || inputElement.value.trim() === '') {
                                errorElement?.classList.remove('hidden'); // Show error if invalid
                                isValid = false;
                            } else {
                                errorElement?.classList.add('hidden'); // Hide error if valid

                                // Use updateWithUnderline for placeholder update
                                const placeholderId = form.placeholders[field];
                                updateWithUnderline(placeholderId, inputElement.value);
                            }
                        }
                    }
                });

                // If all inputs are valid
                if (isValid) {
                    // Close the form or modal
                    closeEditForm();

                    // Show success message
                    const successMessage = document.getElementById('successMessage');
                    if (successMessage) {
                        successMessage.classList.remove('hidden');
                        setTimeout(() => {
                            successMessage.classList.add('hidden');
                        }, 2000); // Hide success message after 2 seconds
                    }
                }
            }
        </script>
    @endsection
