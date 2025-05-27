<div id="editFormModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-out">
    <!-- Modal content -->
    <div
        class="relative p-4 w-full max-w-2xl h-full md:h-auto transform scale-95 transition-transform duration-300 ease-out bg-white rounded-lg shadow sm:p-5">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Create Waiver for Pulmonary Case Form
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
        <form action="{{ route('documents.waiver_for_pulmonary_case.store') }}" method="POST"
            class="max-h-[80vh] overflow-y-auto ">
            @csrf
                    <input type="hidden" name="document_type" value="{{ request('document_type') }}">
                    <input type="hidden" name="control_number" value="{{ $control->control_number }}">
                    <input type="hidden" name="revision" value="{{ $control->revision }}">
                    <input type="hidden" name="date_issued" value="{{ $control->date_issued }}">
            <h4 class="block mb-3 text-lg font-semibold text-blue-500 text-center">Form 1</h4>
            <div class="grid gap-4 mb-4 sm:grid-cols-2 px-2">
                <!-- Date Field -->
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" id="editDate"
                        class="AddDate bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        required="">
                    <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                </div>

                <!-- Patient Name Field -->
                <div>
                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name of Patient
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="patient_name" id="editPatientName"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter patient's full name" required="">
                    <span id="editPatientNameError" class="text-red-500 text-sm hidden">Name is required.</span>
                </div>

                <!-- School name -->
                <div class="col-span-2">
                    <label for="collegeName" class="block mb-2 text-sm font-medium text-gray-900">Name of School
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="collegeName" id="editschoolname"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter school name" required="">
                    <span id="editschoolnameError" class="text-red-500 text-sm hidden">This field is required.</span>
                </div>

                <!-- School year -->
                <div>
                    <label for="department" class="block mb-2 text-sm font-medium text-gray-900">School year
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="year" id="schoolyear"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="2024-2025" required="">
                    <span id="schoolyearError" class="text-red-500 text-sm hidden">This field is required.</span>

                </div>

                <!-- Follow up date check up -->
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Follow-up Check-up Date
                        <span class="text-red-500">*</span></label>
                    <input type="date" name="followUpDate" id="editDateefollowcheck"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        required="">
                    <span id="editDateefollowcheckError" class="text-red-500 text-sm hidden">Follow up check up date is
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
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="additional_date" id="editDate2_${formCount}"
                            class="AddDate bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            >
                        <span id="editDate2Error_${formCount}" class="text-red-500 text-sm hidden">Date is required.</span>
                    </div>

                    <!-- Patient Name Field -->
                    <div>
                        <label for="additional_patient_name" class="block mb-2 text-sm font-medium text-gray-900">Name of Patient
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_patient_name" id="editPatientName2_${formCount}"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Enter patient's full name">
                        <span id="editPatientName2Error_${formCount}" class="text-red-500 text-sm hidden">Name is required.</span>
                    </div>

                    <!-- School name -->
                    <div class="col-span-2">
                        <label for="additional_collegeName" class="block mb-2 text-sm font-medium text-gray-900">Name of School
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_collegeName" id="editschoolname2_${formCount}"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="Enter school name">
                        <span id="editschoolname2Error_${formCount}" class="text-red-500 text-sm hidden">This field is
                            required.</span>
                    </div>

                    <!-- School year -->
                    <div>
                        <label for="additional_year" class="block mb-2 text-sm font-medium text-gray-900">School year
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_year" id="schoolyear2_${formCount}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            placeholder="2024-2025" >
                        <span id="schoolyear2Error_${formCount}" class="text-red-500 text-sm hidden">This field is required.</span>

                    </div>

                    <!-- Follow up date check up -->
                    <div>
                        <label for="additional_followUpDate" class="block mb-2 text-sm font-medium text-gray-900">Follow-up Check-up
                            Date <span class="text-red-500">*</span></label>
                        <input type="date" name="additional_followUpDate" id="editDateefollowcheck2_${formCount}"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                            >
                        <span id="editDateefollowcheck2Error_${formCount}" class="text-red-500 text-sm hidden">Follow up check up
                            date is required.</span>
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
