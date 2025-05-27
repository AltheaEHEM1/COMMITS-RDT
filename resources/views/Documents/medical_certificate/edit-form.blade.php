<div id="editFormModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-out">
    <!-- Modal content -->
    <div
        class="relative p-4 w-full max-w-2xl h-full md:h-auto transform scale-95 transition-transform duration-300 ease-out bg-white rounded-lg shadow sm:p-5">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Edit Medical Certificate
            </h3>
            <button type="button" onclick="closeEditForm()"
                class="text-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-300 bg-gray-200 hover:bg-gray-300 hover:text-gray-900 rounded-full text-sm p-2 ml-auto inline-flex items-center"
                data-modal-toggle="editReportModal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form action="{{ route('documents.medical_certificate.update', $document->id) }}"  method="POST"
            class="max-h-[80vh] overflow-y-auto ">
            @csrf
            @method('PUT')
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
            <h4 class="block mb-3 text-lg font-semibold text-blue-500 text-center">Form 1</h4>
            <div class="grid gap-4 mb-4 sm:grid-cols-2 px-2">
                <!-- Date Field -->
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" id="dateInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('date', $associatedDocument->date ?? '') }}" required="">
                    <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                </div>

                <!-- Patient Name Field -->
                <div>
                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name of Patient
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="patient_name" id="patientNameInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}" placeholder="Enter patient's full name" required="">
                    <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                </div>

                <!-- Treated for -->
                <div class="col-span-2">
                    <label for="sickness" class="block mb-2 text-sm font-medium text-gray-900">Being treated for:
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="sickness" id="reasonInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('sickness', $associatedDocument->sickness ?? '') }}" placeholder="Reason for treatment" required="">
                    <span id="reasonError" class="text-red-500 text-sm hidden">Reason is required.</span>
                </div>

                <!-- Start Date -->
                <div>
                    <label for="startDate" class="block mb-2 text-sm font-medium text-gray-900">Start date of
                        examination <span class="text-red-500">*</span></label>
                    <input type="date" name="startDate" id="startDateInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('startDate', $associatedDocument->startDate ?? '') }}" required="">
                    <span id="startDateError" class="text-red-500 text-sm hidden">Start date is required.</span>
                </div>

                <!-- End Date -->
                <div>
                    <label for="endDate" class="block mb-2 text-sm font-medium text-gray-900">End date of examination
                        <span class="text-red-500">*</span></label>
                    <input type="date" name="endDate" id="endDateInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('endDate', $associatedDocument->endDate ?? '') }}" required="">
                    <span id="endDateError" class="text-red-500 text-sm hidden">End date is required.</span>
                </div>

                <!-- Purpose -->
                <div>
                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-900">Purpose
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="reason" id="purposeInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('reason', $associatedDocument->reason ?? '') }}" placeholder="Purpose" required="">
                    <span id="purposeError" class="text-red-500 text-sm hidden">Purpose field is required.</span>
                </div>

                <!-- Clinic Physician -->
                <div>
                    <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">Physician name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="doctorName" id="physicianInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}" placeholder="Physician's full name" required="">
                    <span id="physicianError" class="text-red-500 text-sm hidden">Physician's name is
                        required.</span>
                </div>
            </div>

            <!--===============Start of form 2 ==================-->
            <div id="formContainer1" class="hidden">
                <hr>
                <h4 class="block mb-2 text-lg font-semibold text-blue-500 mt-3 text-center">Form 2</h4>
                <div class="grid gap-4 mb-4 sm:grid-cols-2 px-2">

                    <!-- Date Field -->
                    <div>
                        <label for="additional_date" class="block mb-2 text-sm font-medium text-gray-900">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="additional_date" id="dateInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additional_date', $associatedDocument->additional_date ?? '') }}">
                        <span id="dateError2" class="text-red-500 text-sm hidden">Date is required.</span>
                    </div>

                    <!-- Patient Name Field -->
                    <div>
                        <label for="additional_patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name
                            of Patient
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_patient_name" id="patientNameInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('addtional_patient_name', $associatedDocument->additional_patient_name ?? '') }}" placeholder="Enter patient's full name" >
                        <span id="nameError2" class="text-red-500 text-sm hidden">Name is required.</span>
                    </div>

                    <!-- Treated for -->
                    <div class="col-span-2">
                        <label for="additional_sickness" class="block mb-2 text-sm font-medium text-gray-900">Being
                            treated for:
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_sickness" id="reasonInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additional_sickness', $associatedDocument->additional_sickness ?? '') }}" placeholder="Reason for treatment" >
                        <span id="reasonError2" class="text-red-500 text-sm hidden">Reason is required.</span>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="additional_startDate" class="block mb-2 text-sm font-medium text-gray-900">Start
                            date of
                            examination <span class="text-red-500">*</span></label>
                        <input type="date" name="additional_startDate" id="startDateInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additionl_startDate', $associatedDocument->additional_startDate ?? '') }}">
                        <span id="startDateError2" class="text-red-500 text-sm hidden">Start date is required.</span>
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="endDate" class="block mb-2 text-sm font-medium text-gray-900">End date of
                            examination
                            <span class="text-red-500">*</span></label>
                        <input type="date" name="additional_endDate" id="endDateInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additional_endDate', $associatedDocument->additional_endDate ?? '') }}">
                        <span id="endDateError2" class="text-red-500 text-sm hidden">End date is required.</span>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label for="additional_reason" class="block mb-2 text-sm font-medium text-gray-900">Purpose
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_reason" id="purposeInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additional_reason', $associatedDocument->additional_reason ?? '') }}" placeholder="Purpose" >
                        <span id="purposeError2" class="text-red-500 text-sm hidden">Purpose field is required.</span>
                    </div>

                    <!-- Clinic Physician -->
                    <div>
                        <label for="additional_doctorName"
                            class="block mb-2 text-sm font-medium text-gray-900">Physician name
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_doctorName" id="physicianInput2"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            value="{{ old('additional_doctorName', $associatedDocument->additional_doctorName ?? '') }}" placeholder="Physician's full name">
                        <span id="physicianError2" class="text-red-500 text-sm hidden">Physician's name is
                            required.</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end w-full gap-3 mt-6">
                <button onclick="addForm()" type="button"
                    class="flex w-full justify-center focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 sm:w-auto">
                    Add Form
                </button>
                <button onclick="saveEdits()" type="submit"
                    class="flex justify-center focus:ring-4 focus:outline-none focus:ring-green-300 w-full px-4 py-3 text-sm bg-green-500 hover:bg-green-600 font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
