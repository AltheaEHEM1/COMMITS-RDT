@extends('layouts.app-layout')

@section('title', 'Medical Clearance')

@section('content')
<style>
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
            margin: 0; /* Siguraduhing walang margin ang page */
            padding: 0; /* Siguraduhing walang padding ang page */
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
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $associatedDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $associatedDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($associatedDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center justify-center mb-0">
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
                        <p class="text-sm mb-0">Quezon City</p>
                        <!-- Medical clearance title -->
                        <h2 class="text-xl font-semibold">MEDICAL CLEARANCE</h2>
                    </div>

                </div>

                <div class="text-right my-4 mb-0 font-Arial">
                    <label class="font-medium">Date: </label>
                    <span id="date-placeholder"
                        class="underline">{{ $associatedDocument->date ? \Carbon\Carbon::parse($associatedDocument->date)->format('F j, Y') : '__________' }}
                    </span>
                </div>

                <div class="space-y-4 font-Arial mb-0">
                    <p>To Whom It May Concern:</p>
                    <p class="indent-8">
                        This is to clarify that <span id="name-placeholder" class="underline">
                            {{ $associatedDocument->patient_name ?? '______________' }}</span>
                        has been examined by the undersigned and found to be physically fit at the time of examination.
                    </p>
                    <p class="indent-8">
                        This certification is issued upon his/her request for <span id="excuse-placeholder"
                            class="underline">{{ $associatedDocument->excuse ?? '_____________' }}</span> purposes but not
                        for medico-legal
                        reason.
                    </p>

                </div>
                <!-- Flex Row for COVID Status and Signature -->
                <div class="flex justify-between pt-5">
                    <div id="" class="w-1/2 text-left">
                        <p>COVID-19 Vaccination Status:</p>
                        <p><span class="checkbox"
                                id="status-unvaccinated">{{ $associatedDocument->vaccination_status == 'Unvaccinated' ? '___✓___' : '_____' }}</span>
                            Unvaccinated</p>
                        <p><span class="checkbox"
                                id="status-incomplete">{{ $associatedDocument->vaccination_status == 'Primary Incomplete' ? '___✓___' : '_____' }}</span>
                            Primary series incomplete</p>
                        <p><span class="checkbox"
                                id="status-completed">{{ $associatedDocument->vaccination_status == 'Primary Complete' ? '___✓___' : '_____' }}</span>
                            Primary dose / series completed</p>
                        <p><span class="checkbox"
                                id="status-boosters">{{ $associatedDocument->vaccination_status == 'Boosters' ? '___✓___' : '_____' }}</span>
                            1st / second Boosters</p>
                    </div>
                    <div class="w-11/30 text-left">
                        <p><span id="x-ray-placeholder2"
                                class="underline">{{ $associatedDocument->doctorName ?? '__________' }}</span><label
                                class="font-medium"> M.D. </label></p>
                        <p><span id="x-ray-placeholder2"
                                class="font-medium">{{ $associatedDocument->position ?? '__________' }}</span> </p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder2" class="underline">
                                {{ $associatedDocument->license_number ?? '__________' }}</span></p>
                    </div>
                </div>
            </div>
        </div>


        <div class="page">
            <!-- Document 2 (duplicate the structure as needed) -->
            <div class="container">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $associatedDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $associatedDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($associatedDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center justify-center mb-0">
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
                        <p class="text-sm mb-0">Quezon City</p>
                        <!-- Medical clearance title -->
                        <h2 class="text-xl font-semibold">MEDICAL CLEARANCE</h2>
                    </div>

                </div>

                <div class="text-right my-4 mb-0 font-Arial">
                    <label class="font-medium">Date: </label>
                    <span id="date-placeholder"
                        class="underline">{{ $associatedDocument->additional_date ? \Carbon\Carbon::parse($associatedDocument->additional_date)->format('F j, Y') : '__________' }}
                    </span>
                </div>

                <div class="space-y-4 font-Arial mb-0">
                    <p>To Whom It May Concern:</p>
                    <p class="indent-8">
                        This is to clarify that <span id="name-placeholder" class="underline">
                            {{ $associatedDocument->additional_patient_name ?? '______________' }}</span>
                        has been examined by the undersigned and found to be physically fit at the time of examination.
                    </p>
                    <p class="indent-8">
                        This certification is issued upon his/her request for <span id="excuse-placeholder"
                            class="underline">{{ $associatedDocument->additional_excuse ?? '_____________' }}</span>
                        purposes but not for medico-legal
                        reason.
                    </p>
                    <div class="mt-4">
                        <span>X-ray Result: <span id="x-ray-placeholder2" class="underline">
                                {{ $associatedDocument->xray_result ?? '_____________' }}</span>
                    </div>
                </div>
                <!-- Flex Row for COVID Status and Signature -->
                <div class="flex justify-between pt-0">
                    <div id="" class="w-1/2 text-left">
                        <p>COVID-19 Vaccination Status:</p>
                        <p><span class="checkbox"
                                id="status-unvaccinated">{{ $associatedDocument->additional_vaccination_status == 'Unvaccinated' ? '___✓___' : '_____' }}</span>
                            Unvaccinated</p>
                        <p><span class="checkbox"
                                id="status-incomplete">{{ $associatedDocument->additional_vaccination_status == 'Primary Incomplete' ? '___✓___' : '_____' }}</span>
                            Primary series incomplete</p>
                        <p><span class="checkbox"
                                id="status-completed">{{ $associatedDocument->additional_vaccination_status == 'Primary Complete' ? '___✓___' : '_____' }}</span>
                            Primary dose / series completed</p>
                        <p><span class="checkbox"
                                id="status-boosters">{{ $associatedDocument->additional_vaccination_status == 'Boosters' ? '___✓___' : '_____' }}</span>
                            1st / second Boosters</p>
                    </div>
                    <div class="w-11/30 text-left">
                        <p><span id="x-ray-placeholder2"
                                class="underline">{{ $associatedDocument->additional_doctorName ?? '__________' }}</span><label
                                class="font-medium"> M.D. </label></p>
                        <p><span id="x-ray-placeholder2"
                                class="font-medium">{{ $associatedDocument->additional_position ?? '__________' }}</span>
                        </p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder2" class="underline">
                                {{ $associatedDocument->additional_license_number ?? '__________' }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==== Edit Form Modal ==-->
    @include('Documents.medical_clearance.edit-form')
    {{-- <div id="editFormModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="modal-content1 bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
            <!-- Close Button in Top-Right -->
            <span class="close absolute top-2.5 right-2.5 text-red-500 text-2xl cursor-pointer hover:text-red-700"
                onclick="closeEditForm()">&times;</span>

            <!-- Modal Title -->
            <h3 class="text-xl font-bold mb-4 text-gray-700">Add Medical Clearance Form</h3>

            <!-- Form Container -->

            <form action="{{ route('documents.medical_clearance.update', $document->id) }}" method="POST">
                <h2 class="text-xl font-medium mb-4 mt-6 text-gray-700 text-center">Form 1</h2>
                @csrf
                @method('PUT')
                <!-- Date Field -->
                <div id="formContainer" class="space-y-4">
                    <div class="form-group">
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
                        <label class="block text-gray-600 font-medium mb-1">Date:</label>
                        <input type="date" id="editDate"
                            class="editDate w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="date" value="{{ old('date', $associatedDocument->date ?? '') }}" required>
                        <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                    </div>

                    <!-- Patient Name Field -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Patient's Name:</label>
                        <input type="text" id="editPatientName" name="patient_name"
                            value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}"
                            class="editPatientName w-full border rounded-md px-3 py-2" placeholder="Enter patient's name"
                            required>
                        <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                    </div>

                    <!-- Excuse Field -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Excuse for:</label>
                        <input type="text" id="editExcuse" class="editExcuse w-full border rounded-md px-3 py-2"
                            name="excuse" value="{{ old('excuse', $associatedDocument->excuse ?? '') }}"
                            placeholder="Reason for excuse">
                    </div>

                    <!-- Vaccination Status -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-2">COVID-19 Vaccination Status:</label>
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="vaccination_status" value="Unvaccinated"
                                    class="text-blue-500"
                                    {{ $associatedDocument->vaccination_status == 'Unvaccinated' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Unvaccinated</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="vaccination_status" value="Primary Incomplete"
                                    class="text-blue-500"
                                    {{ $associatedDocument->vaccination_status == 'Primary Incomplete' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Primary series incomplete</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="vaccination_status" value="Primary Complete"
                                    class="text-blue-500"
                                    {{ $associatedDocument->vaccination_status == 'Primary Complete' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Primary dose / series completed</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="vaccination_status" value="Boosters" class="text-blue-500"
                                    {{ $associatedDocument->vaccination_status == 'Boosters' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">1st / second Boosters</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Physician Name:</label>
                        <input type="text" id="lic_no" class="Licno w-full border rounded-md px-3 py-2"
                            name="doctorName" value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}"
                            placeholder="Physician Name" required>
                        <span id="PhcError" class="text-red-500 text-sm hidden">Physician is required.</span>
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Physician's Position:</label>
                        <input type="text" id="lic_no" class="Licno w-full border rounded-md px-3 py-2"
                            name="position" value="{{ old('position', $associatedDocument->position ?? '') }}"
                            placeholder="Position" required>
                        <span id="PstError" class="text-red-500 text-sm hidden">Position is required.</span>
                    </div>
                    <!-- License Number -->
                    <div class="form-group">
                        <label class="block text-gray-600 font-medium mb-1">Lic No:</label>
                        <input type="text" id="lic_no" class="Licno w-full border rounded-md px-3 py-2"
                            name="license_number"
                            value="{{ old('license_number', $associatedDocument->license_number ?? '') }}"
                            placeholder="License number" required>
                        <span id="licError" class="text-red-500 text-sm hidden">License number is required.</span>
                    </div>
                </div>

                <div class="hidden" id="formContainer1">
                    <h2 class="text-xl text-center font-semibold mb-7 text-gray-700 mt-4">Form 2</h2>

                    <div class="space-y-4" id="form2"> <!-- Added space-y-4 here -->
                        <label class="block text-gray-600 font-medium mb-1">Date:</label>
                        <input type="date" id="editDate2" name="additional_date"
                            value="{{ old('additional_date', $associatedDocument->additional_date ?? '') }}"
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <label class="block text-gray-600 font-medium mb-1">Patient's Name:</label>
                        <input type="text" id="editPatientName2" name="additional_patient_name"
                            value="{{ old('additional_patient_name', $associatedDocument->additional_patient_name ?? '') }}"
                            class="w-full border rounded-md px-3 py-2" placeholder="Enter patient's name">

                        <label class="block text-gray-600 font-medium mb-1">Excuse for:</label>
                        <input type="text" id="editExcuse2" name="additional_excuse"
                            value="{{ old('additional_excuse', $associatedDocument->additional_excuse ?? '') }}"
                            class="w-full border rounded-md px-3 py-2" placeholder="Reason for excuse">

                        <label class="block text-gray-600 font-medium mb-1">X-ray result:</label>
                        <input type="text" id="editXray2" name="xray_result"
                            value="{{ old('xray_result', $associatedDocument->xray_result ?? '') }}"
                            class="w-full border rounded-md px-3 py-2" placeholder="X-ray result">

                        <label class="block text-gray-600 font-medium mb-2">COVID-19 Vaccination Status:</label>
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="additional_vaccination_status" value="Unvaccinated"
                                    class="text-blue-500"
                                    {{ $associatedDocument->additional_vaccination_status == 'Unvaccinated' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Unvaccinated</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="additional_vaccination_status" value="Primary Incomplete"
                                    class="text-blue-500"
                                    {{ $associatedDocument->additional_vaccination_status == 'Primary Incomplete' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Primary series incomplete</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="additional_vaccination_status" value="Primary Complete"
                                    class="text-blue-500"
                                    {{ $associatedDocument->additional_vaccination_status == 'Primary Complete' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Primary dose / series completed</span>
                            </label><br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="additional_vaccination_status" value="Boosters"
                                    class="text-blue-500"
                                    {{ $associatedDocument->additional_vaccination_status == 'Boosters' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">1st / second Boosters</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Physician Name:</label>
                            <input type="text" id="lic_no2" class="Licno w-full border rounded-md px-3 py-2"
                                name="additional_doctorName"
                                value="{{ old('additional_doctorName', $associatedDocument->additional_doctorName ?? '') }}"
                                placeholder="Physician Name">
                            <span id="PhcError" class="text-red-500 text-sm hidden">Physician is required.</span>
                        </div>

                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Physician's Position:</label>
                            <input type="text" id="lic_no2" class="Licno w-full border rounded-md px-3 py-2"
                                name="additional_position"
                                value="{{ old('additional_position', $associatedDocument->additional_position ?? '') }}"
                                placeholder="Position">
                            <span id="PstError" class="text-red-500 text-sm hidden">Position is required.</span>
                        </div>
                        <!-- License Number -->
                        <div class="form-group">
                            <label class="block text-gray-600 font-medium mb-1">Lic No:</label>
                            <input type="text" id="lic_no2" class="Licno w-full border rounded-md px-3 py-2"
                                name="additional_license_number"
                                value="{{ old('additional_license_number', $associatedDocument->additional_license_number ?? '') }}"
                                placeholder="License number">
                            <span id="licError" class="text-red-500 text-sm hidden">License number is
                                required.</span>
                        </div>
                    </div>
                    <!-- End of space-y-4 -->
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button onclick="addForm()" type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Add Form
                    </button>
                    <button onclick="saveEdits()" type="submit"
                        class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                        Submit
                    </button>
                </div>
            </form>
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

        function openEditForm() {
            // document.getElementById("editFormModal").classList.remove("hidden");

            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
            checkAdditionalFields();
        }

        function closeEditForm() {
            // document.getElementById("editFormModal").classList.add("hidden");

            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

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

        function saveEdits() {
            // Capture user inputs for Form 1
            const waiverDate1 = document.querySelector(".editDate").value;
            const patientName1 = document.querySelector(".editPatientName").value;
            const excuse1 = document.querySelector(".editExcuse").value;
            const licNoValue1 = document.querySelector(".Licno").value;

            // Capture user inputs for Form 2
            const waiverDate2 = document.getElementById("editDate1")?.value || ""; // Check if form exists
            const patientName2 = document.getElementById("editPatientName1")?.value || "";
            const excuse2 = document.getElementById("editExcuse1")?.value || "";
            // const xrayResult2 = document.getElementById("editXray1")?.value || "";
            const licNoValue2 = document.getElementById("licNo1")?.value || "";
            const xrayResult2 = document.getElementById("editXray1")?.value || "";

            // Validation logic for Form 1
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



            // Validation logic for Form 2 (if it exists)
            if (waiverDate2 || patientName2 || excuse2 || licNoValue2 || xrayResult2) {
                if (!waiverDate2) {
                    isValid = false;
                    alert("Please fill in the Date for Form 2.");
                }
                if (!patientName2.trim()) {
                    isValid = false;
                    alert("Please fill in the Patient Name for Form 2.");
                }
                if (!licNoValue2.trim()) {
                    isValid = false;
                    alert("Please fill in the License Number for Form 2.");
                }
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

        function checkAdditionalFields() {
            const hasValue = document.getElementById("editDate2").value || document.getElementById("editPatientName2")
                .value || document.getElementById("editExcuse2").value || document.getElementById("licNo2").value ||
                document.getElementById("editXray2").value;
            if (hasValue) {
                document.getElementById("formContainer1").classList.remove("hidden");
                document.querySelector("button[onclick='addForm()']").style.display = 'none';
            } else {
                document.getElementById("formContainer1").classList.add("hidden");
                document.querySelector("button[onclick='addForm()']").style.display = 'block';
            }
        }
    </script>
@endpush
