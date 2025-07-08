@extends('layouts.app-layout')

@section('title', 'Annual Medical Clearance')

@section('content')

<style>
    @page {
        margin: 0; /* Remove default print page margin */
    }
    @media print {
      .container {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
      }

      .md\:py-20 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
      }
      * {
            box-sizing: border-box;
    }

    .page {
        margin-top: 0 !important;
        padding-top: 0 !important;
        position: relative !important;
        top: -150px !important;
        padding-right: 10px !important;
      }

      body, html {
        margin: 0 !important;
        padding: 0 !important;
        height: 100% !important;
        overflow: hidden !important;
      }
      body {
        font-family: Arial;
        font-size: 13px;
    }

    }
  </style>

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
            <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 mr-2" onclick="openaddForm()"
                aria-label="add Form">
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
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $associatedDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $associatedDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($associatedDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
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
                        <h2 class="text-xl font-semibold">ANNUAL MEDICAL CLEARANCE</h2>
                    </div>

                </div>

                <div class="my-10 mb-10 text-right font-Arial">
                    <label class="font-medium">Date: </label>
                    <span id="letterDate" class="underline">
                        {{ \Carbon\Carbon::parse($associatedDocument->date)->format('F j, Y') }} </span>
                </div>
                <div class="space-y-4 font-Arial mb-0">
                    <p>To Whom It May Concern:</p>
                    <p class="indent-8">
                        This is to clarify that <span id="name-placeholder"
                            class="underline">{{ $associatedDocument->patient_name }}</span>
                        has been examined by the undersigned at the PUP Medical Clinic on <span id="excuse-placeholder"
                            class="underline">{{ \Carbon\Carbon::parse($associatedDocument->excuseDate)->format('F j, Y') }}.</span>
                    </p>
                    <p class="indent-8">
                        This certification is issued upon his/her request for
                        <span class="font-bold italic font-arial">Annual Medical Clearance</span>
                        but not for medico-legal purpose.
                    </p>

                </div>
                <!-- signature -->
                <div class="flex justify-end p-5 signature-block">
                    <div class="w-11/30 text-left">
                        <p><span id="physician-name-placeholder" class="underline">{{ $associatedDocument->doctorName }}
                                <label class="font-medium">M.D. </label></span></p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder" class="underline">
                                {{ $associatedDocument->license_number }}</span></p>
                    </div>
                </div>

            </div>


        <!-- Document 2 (duplicate the structure as needed) -->
        <div class="container mt-5">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $associatedDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $associatedDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($associatedDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
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
                        <h2 class="text-xl font-semibold">ANNUAL MEDICAL CLEARANCE</h2>
                    </div>

                </div>

                <div class="text-right my-10 mb-8 font-Arial">
                    <label class="font-medium">Date: </label>
                    <span id="date-placeholder"
                        class="underline">{{ $associatedDocument->additional_date ? \Carbon\Carbon::parse($associatedDocument->additional_date)->format('F j, Y') : '__________' }}
                    </span>
                </div>

                <div class="space-y-4 font-Arial mb-0">
                    <p>To Whom It May Concern:</p>
                    <p class="indent-8">
                        This is to clarify that <span id="name-placeholder"
                            class="underline">{{ $associatedDocument->additional_patient_name ?? '__________' }}</span>
                        has been examined by the undersigned at the PUP Medical Clinic on <span id="excuse-placeholder"
                            class="underline">{{ $associatedDocument->additional_excuse_date ? \Carbon\Carbon::parse($associatedDocument->additional_excuse_date)->format('F j, Y') : '__________' }}
                            .</span>
                    </p>
                    <p class="indent-8">
                        This certification is issued upon his/her request for
                        <span class="font-bold italic font-arial">Annual Medical Clearance</span>
                        but not for medico-legal purpose.
                    </p>

                </div>
                <!-- signature -->
                <div class="flex justify-end p-5 signature-block">
                    <div class="w-11/30 text-left">
                        <p><span id="physician-name-placeholder"
                                class="underline">{{ $associatedDocument->additional_doctorName ?? '__________' }} <label
                                    class="font-medium">M.D. </label></span></p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder" class="underline">
                                {{ $associatedDocument->additional_license_number ?? '__________' }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @include('Documents.annual_medical_clearance.edit-form')

    {{--
        <div id="addFormModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="modal-content1 bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
                <!-- Close Button in Top-Right -->
                <span class="close absolute top-2.5 right-2.5 text-red-500 text-3xl cursor-pointer hover:text-red-700"
                    onclick="closeaddForm()">&times;</span>

                <!-- Modal Title -->
                <h3 class="text-xl font-bold mb-4 text-gray-700">Add Annual Medical Clearance Form</h3>

                <!-- Form Container -->
                <div id="formContainer" class="space-y-4">
                    <form action="{{ route('documents.annual_medical_clearance.update', $document->id) }}"
                        method="POST">
                        <h2 class="text-xl font-medium mb-4 mt-6 text-gray-700 text-center">Form 1</h2>
                        @csrf
                        @method('PUT') <!-- This ensures the method is PUT for updating -->
                        <div class="form-group">
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
                                <label class="block text-gray-600 font-medium mb-1">Date:</label>
                            <input type="date" id="addDate" name="date" value="{{ old('date', $associatedDocument->date ?? '') }}"
                                class="addDate w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                        </div>

                        <!-- Patient Name Field -->
                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Patient's Name:</label>
                            <input type="text" id="addPatientName" name="patient_name"
                                value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}"
                                class="addPatientName w-full border rounded-md px-3 py-2"
                                placeholder="Enter patient's name" required>
                            <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                        </div>

                        <!-- Date examination -->
                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Examination Date: </label>
                            <input type="date" id="addExcuse" name="excuseDate"
                                value="{{ old('excuseDate', $associatedDocument->excuseDate ?? '') }}"
                                class="addExcuse w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <span id="dateError" class="text-red-500 text-sm hidden">Date Examination is required.</span>
                        </div>
                        <!-- Physician name -->
                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Physician Name:</label>
                            <input type="text" id="physician-name" class="w-full border rounded-md px-3 py-2"
                                name="doctorName" value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}"
                                placeholder="Enter Physician Name" required>
                            <span id="physicianError" class="text-red-500 text-sm hidden">Physician name is
                                required.</span>
                        </div>
                        <!-- Lic No -->
                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Lic No:</label>
                            <input type="text" id="licNo0" class="w-full border rounded-md px-3 py-2"
                                name="license_number"
                                value="{{ old('license_number', $associatedDocument->license_number ?? '') }}"
                                placeholder="License number" required>
                            <span id="licError" class="text-red-500 text-sm hidden">License number is required.</span>
                        </div>

                <div class="hidden" id="formContainer1">
                    <div class="space-y-2">
                    <h1 class="text-xl font-medium mb-4 mt-6 text-gray-700 text-center">Form 2</h2>
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
                        <label class="block text-gray-600 font-medium mb-1">Date:</label>
                        <input type="date" id="addDate2" name="additional_date" value="{{ old('additional_date', $associatedDocument->additional_date ?? '') }}"
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                    <label class="block text-gray-600 font-medium mb-1">Patient's Name:</label>
                                    <input type="text" id="addPatientName2" name="additional_patient_name"
                                        value="{{ old('additional_patient_name', $associatedDocument->additional_patient_name ?? '') }}"
                                        class="w-full border rounded-md px-3 py-2" placeholder="Enter patient's name">

                                    <label class="block text-gray-600 font-medium mb-1">Examination Date:</label>
                                    <input type="date" id="addExcuse2" name="additional_excuse_date"
                                        value="{{ old('additional_excuse_date', $associatedDocument->additional_excuse_date ?? '') }}"
                                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">


                                    <label class="block text-gray-600 font-medium mb-1">Physician Name:</label>
                                    <input type="text" id="addXray2" name="additional_doctorName"
                                        value="{{ old('additional_doctorName', $associatedDocument->additional_doctorName ?? '') }}"
                                        class="w-full border rounded-md px-3 py-2" placeholder="Enter Physician Name">


                                    <label class="block text-gray-600 font-medium mb-1">Lic No:</label>
                                    <input type="text" id="licNo2" name="additional_license_number"
                                        value="{{ old('additional_license_number', $associatedDocument->additional_license_number ?? '') }}"
                                        class="w-full border rounded-md px-3 py-2" placeholder="License number">
                            </div> <!-- End of space-y-4 -->
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button onclick="addForm()" type="button"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                                Add Form
                            </button>
                            <button onclick="saveAdd()" type="submit"
                                class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

    <!-- Success Notification -->
    {{-- <div id="successMessage" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
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
                <p class="text-lg font-semibold">Successfully Edited!</p>
            </div>
        </div> --}}

@endsection

@push('scripts')
    <script>
        function printWaiver() {
            window.print();
        }

        function goBack() {
            window.location.href = "{{ route('documents.index') }}";
        }

        function openaddForm() {
            // document.getElementById("addFormModal").classList.remove("hidden");

            let modal = document.getElementById("addFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
            checkAdditionalFields();
        }

        function closeAddForm() {
            // document.getElementById("addFormModal").classList.add("hidden");
            let modal = document.getElementById("addFormModal");
            let modalContent = modal.querySelector("div.relative");
            modal.classList.add("hidden");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        let formCount = 1;

        function addForm() {
            formCount++;
            const formContainer1 = document.getElementById("formContainer1");
            formContainer1.classList.remove("hidden");
            if (formCount === 2) {
                document.querySelector("button[onclick='addForm()']").style.display = 'none';
            }
        }

        function checkAdditionalFields() {
            const hasValue = document.getElementById("addDate2").value || document.getElementById("addPatientName2")
                .value || document.getElementById("addExcuse2").value || document.getElementById("licNo2").value || document
                .getElementById("addXray2").value;
            if (hasValue) {
                document.getElementById("formContainer1").classList.remove("hidden");
                document.querySelector("button[onclick='addForm()']").style.display = 'none';
            } else {
                document.getElementById("formContainer1").classList.add("hidden");
                document.querySelector("button[onclick='addForm()']").style.display = 'block';
            }
        }

        function saveAdd() {
            // Capture user inputs for Form 1
            const waiverDate1 = document.querySelector(".addDate").value;
            const patientName1 = document.querySelector(".addPatientName").value;
            const excuse1 = document.querySelector(".addExcuse").value;
            const physicianName = document.getElementById("physician-name").value;
            const licNoValue1 = document.getElementById("licNo0").value;

            let isValid = true;

            // Validate Date for Form 1
            const dateError = document.getElementById("dateError");
            if (!waiverDate1) {
                dateError.classList.remove("hidden");
                isValid = false;
            } else {
                dateError.classList.add("hidden");
            }

            // Validate Name for Form 1
            const nameError = document.getElementById("nameError");
            if (!patientName1.trim()) {
                nameError.classList.remove("hidden");
                isValid = false;
            } else {
                nameError.classList.add("hidden");
            }

            // Validate License for Form 1
            const licError = document.getElementById("licError");
            if (!licNoValue1.trim()) {
                licError.classList.remove("hidden");
                isValid = false;
            } else {
                licError.classList.add("hidden");
            }

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
