<div id="editFormModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-out">
    <!-- Modal content -->
    <div
        class="relative p-4 w-full max-w-2xl h-full md:h-auto transform scale-95 transition-transform duration-300 ease-out bg-white rounded-lg shadow sm:p-5">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Edit Excuse Letter
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
        <form action="{{ route('documents.excuse_letter.update', $document->id) }}" method="POST"
            class="max-h-[80vh] overflow-y-auto ">
            @csrf
            @method('PUT')
                                    <input type="hidden" name="document_type" value="{{ $document->document_type }}">
                                    <input type="hidden" name="control_number" value="{{ $associatedDocument->control_number }}">
                                    <input type="hidden" name="revision" value="{{ $associatedDocument->revision }}">
                                    <input type="hidden" name="date_issued" value="{{ $associatedDocument->date_issued }}">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 px-2">
                <!-- Date -->
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date
                        <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('date', $associatedDocument->date ?? '') }}" required="">
                    <span id="dateError1" class="text-red-500 text-sm hidden">Date is required</span>
                </div>

                <!-- Recepient -->
                <div>
                    <label for="recipient" class="block mb-2 text-sm font-medium text-gray-900">Name of Recipient
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="recipient" id="recipient"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('recipient', $associatedDocument->recipient ?? '') }}" placeholder="Enter name of recipient" required="">
                    <span id="nameError" class="text-red-500 text-sm hidden">Name of recipient is required.</span>
                </div>

                <!-- Student name -->
                <div>
                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">Student name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="patient_name" id="patient_name"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('patient_name', $associatedDocument->patient_name ?? '') }}" placeholder="Enter name of student" required="">
                    <span id="nameError" class="text-red-500 text-sm hidden">Name of student is required.</span>
                </div>

                <!-- Department -->
                <div>
                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">Department
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="department" id="department"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('department', $associatedDocument->department ?? '') }}" placeholder="Enter name of student's department or program" required="">
                    <span id="departmentError" class="text-red-500 text-sm hidden">Name of department is required.</span>
                </div>

                <!-- Date of Absence -->
                <div>
                    <label for="excuse_for" class="block mb-2 text-sm font-medium text-gray-900">Date of absence
                        <span class="text-red-500">*</span></label>
                    <input type="date" name="excuse_for" id="excuse_for"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('excuse_for', $associatedDocument->excuse_for ?? '') }}" required="">
                    <span id="dateError2" class="text-red-500 text-sm hidden">Please enter the date of absence.</span>
                </div>

                <!-- Reason for absence -->
                <div>
                    <label for="cause" class="block mb-2 text-sm font-medium text-gray-900">Reason for absence
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="cause" id="cause"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('cause', $associatedDocument->cause ?? '') }}"  placeholder="Enter reason for absence" required="">
                    <span id="cause" class="text-red-500 text-sm hidden">Please enter reason for absence</span>
                </div>

                <!-- Physician's name -->
                <div>
                    <label for="doctorName" class="block mb-2 text-sm font-medium text-gray-900">Physician's name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="doctorName" id="doctorName"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        value="{{ old('doctorName', $associatedDocument->doctorName ?? '') }}" placeholder="Enter physician's name" required="">
                    <span id="licenseNoError" class="text-red-500 text-sm hidden">Please enter the physician's name</span>
                </div>
            </div>

            <div class="flex items-center justify-end w-full gap-3 mt-6">
                <button onclick="closeEditForm()" type="button"
                    class="flex w-full justify-center focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 sm:w-auto">
                    Close
                </button>
                <button onclick="saveEdits()" type="submit"
                    class="flex justify-center focus:ring-4 focus:outline-none focus:ring-green-300 w-full px-4 py-3 text-sm bg-green-500 hover:bg-green-600 font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
