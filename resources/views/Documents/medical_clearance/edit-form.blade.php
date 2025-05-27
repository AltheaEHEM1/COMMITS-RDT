<div id="editFormModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-out">
    <!-- Modal content -->
    <div
        class="relative p-4 w-full max-w-2xl h-full md:h-auto transform scale-95 transition-transform duration-300 ease-out bg-white rounded-lg shadow sm:p-5">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Edit Medical Clearance
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
        <form action="{{ route('documents.medical_clearance.update', $document->id) }}" method="POST"
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
                    <input type="date" name="date" id="editDate"
                        class="editDate bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('date', $associatedDocument->date ?? '') }}" required="">
                    <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                </div>

                <!-- Patient Name Field -->
                <div>
                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name of Patient
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="patient_name" id="editPatientName"
                        class="editPatientName bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}" placeholder="Enter patient's full name" required="">
                    <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                </div>

                <!-- Excuse for -->
                <div class="col-span-2">
                    <label for="sickness" class="block mb-2 text-sm font-medium text-gray-900">Excuse for:
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="excuse" id="editExcuse"
                        class="editExcuse bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('excuse', $associatedDocument->excuse ?? '') }}" placeholder="Reason for excuse" required="">
                    <span id="excuseError" class="text-red-500 text-sm hidden">This field is required.</span>
                </div>

                <!-- Vaccination Status -->
                <div>
                    <label for="vaccination_status" class="block mb-2 text-sm font-medium text-gray-900">COVID-19
                        Vaccination Status <span class="text-red-500">*</span></label>
                    <select id="vaccination_status" name="vaccination_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                        <option value="">Select status</option>
                        <option value="Unvaccinated" {{ (old('vaccination_status', $associatedDocument->vaccination_status) == 'Unvaccinated') ? 'selected' : '' }}>Unvaccinated</option>
                        <option value="Primary Incomplete" {{ (old('vaccination_status', $associatedDocument->vaccination_status) == 'Primary Incomplete') ? 'selected' : '' }}>Primary Series Incomplete</option>
                        <option value="Primary Complete" {{ (old('vaccination_status', $associatedDocument->vaccination_status) == 'Primary Complete') ? 'selected' : '' }}>Primary dose / series completed</option>
                        <option value="Boosters" {{ (old('vaccination_status', $associatedDocument->vaccination_status) == 'Boosters') ? 'selected' : '' }}>1st / second Boosters</option>
                    </select>
                </div>

                <!-- Physician Name -->
                <div>
                    <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">Physician's name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="doctorName" id="doctorName" value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter physician's full name" required="">
                    <span id="PhcError" class="text-red-500 text-sm hidden">Physician name is required.</span>
                </div>

                <!-- Physician's position -->
                <div>
                    <label for="position" class="block mb-2 text-sm font-medium text-gray-900">Physician's position
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="position" id="position" value="{{ old('position', $associatedDocument->position ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Physician position" required="">
                    <span id="PstError" class="text-red-500 text-sm hidden">Physician's position is required.</span>
                </div>

                <!-- License Number -->
                <div>
                    <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">License number
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="license_number" id="lic_no" value="{{ old('license_number', $associatedDocument->license_number ?? '') }}"
                        class="Licno bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Physician's license number" required="">
                    <span id="licError" class="text-red-500 text-sm hidden">License number is
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
                        <input type="date" name="additional_date" id="editDate2" value="{{ old('additional_date', $associatedDocument->additional_date ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                        <span id="dateError2" class="text-red-500 text-sm hidden">Date is required.</span>
                    </div>

                    <!-- Patient Name Field -->
                    <div>
                        <label for="additional_patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name
                            of Patient
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_patient_name" id="editPatientName2" value="{{ old('additional_patient_name', $associatedDocument->additional_patient_name ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Enter patient's full name">
                        <span id="nameError2" class="text-red-500 text-sm hidden">Name is required.</span>
                    </div>

                    <!-- Excuse for -->
                    <div class="col-span-2">
                        <label for="additional_excuse" class="block mb-2 text-sm font-medium text-gray-900">Excuse for:
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_excuse" id="editExcuse2"  value="{{ old('additional_excuse', $associatedDocument->additional_excuse ?? '') }}"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Reason for excuse">
                        <span id="excuseError" class="text-red-500 text-sm hidden">This field is required.</span>
                    </div>

                    <!-- Xray results -->
                    <div class="col-span-2">
                        <label for="xray_result" class="block mb-2 text-sm font-medium text-gray-900">X-ray result
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="xray_result" id="editXray2" value="{{ old('xray_result', $associatedDocument->xray_result ?? '') }}"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="X-ray result">
                    </div>

                    <!-- Vaccination Status -->
                    <div>
                        <label for="additional_vaccination_status" class="block mb-2 text-sm font-medium text-gray-900">COVID-19
                            Vaccination Status <span class="text-red-500">*</span></label>
                        <select id="additional_vaccination_status2" name="additional_vaccination_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                            <option value="">Select status</option>
                            <option value="Unvaccinated" {{ (old('additional_vaccination_status', $associatedDocument->additional_vaccination_status) == 'Unvaccinated') ? 'selected' : '' }}>Unvaccinated</option>
                            <option value="Primary Incomplete" {{ (old('additional_vaccination_status', $associatedDocument->additional_vaccination_status) == 'Primary Incomplete') ? 'selected' : '' }}>Primary Series Incomplete</option>
                            <option value="Primary Complete" {{ (old('additional_vaccination_status', $associatedDocument->additional_vaccination_status) == 'Primary Complete') ? 'selected' : '' }}>Primary dose / series completed</option>
                            <option value="Boosters" {{ (old('additional_vaccination_status', $associatedDocument->additional_vaccination_status) == 'Boosters') ? 'selected' : '' }}>1st / second Boosters</option>
                        </select>
                    </div>

                    <!-- Physician Name -->
                    <div>
                        <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">Physician's name
                            <span class="text-red-500">*</span></label>
                        <input type="date" name="additional_doctorName" id="doctorName2" value="{{ old('additional_doctorName', $associatedDocument->additional_doctorName ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Enter physician's full name">
                        <span id="PhcError" class="text-red-500 text-sm hidden">Physician name is required.</span>
                    </div>

                    <!-- Physician's position -->
                    <div>
                        <label for="position" class="block mb-2 text-sm font-medium text-gray-900">Physician's
                            position
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_position" id="position2" value="{{ old('additional_position', $associatedDocument->additional_position ?? '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Physician position">
                        <span id="PstError" class="text-red-500 text-sm hidden">Physician's position is
                            required.</span>
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">License number
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_license_number" id="lic_no2" value="{{ old('additional_license_number', $associatedDocument->additional_license_number ?? '') }}"
                            class="Licno bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Physician's license number" >
                        <span id="licError" class="text-red-500 text-sm hidden">License number is
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
