<div id="addReportModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <!-- Modal content -->
    <div
        class="relative w-full h-full max-w-2xl p-4 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <!-- Modal header -->
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Add New Report
            </h3>
            <button type="button" onclick="hideAddReportModal()"
                class="inline-flex items-center p-2 ml-auto text-sm text-gray-400 bg-gray-200 rounded-full focus:ring-4 focus:outline-none focus:ring-gray-300 hover:bg-gray-300 hover:text-gray-900"
                data-modal-toggle="addReportModal">
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
        <form class="max-h-[80vh] overflow-y-auto" id="addReportForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 px-3 mb-4 sm:grid-cols-2">
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Report title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter title of the report" required="">
                </div>
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Patient's full name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter patient's full name" required="">
                </div>
                <div>
                    <label for="sex" class="block mb-2 text-sm font-medium text-gray-900">Sex <span
                            class="text-red-500">*</span></label>
                    <select id="sex" name="sex" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                        <option value="">Select biological sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Age <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="age" id="age"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter patient's age" required>
                </div>
                <div>
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category <span
                            class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                        <option value="">Select category</option>
                        <option value="Students">Students</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Administrative">Administrative</option>
                        <option value="Dependents">Dependents</option>
                        <option value="Visitors">Visitors</option>
                    </select>
                </div>
                <div>
                    <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-900">Diagnosis <span
                            class="text-red-500">*</span></label>
                    <select id="diagnosis" name="diagnosis" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5">
                        <option value="">Select diagnosis</option>
                        @foreach ($services as $service)
                            @if (!$loop->last)
                                {{-- to not include the "Total Online Consult" --}}
                                <option value="{{ $service['name'] }}">{{ $service['name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="complaint" class="block mb-2 text-sm font-medium text-gray-900">Complaint Reason <span
                        class="text-red-500">*</span>
                    </label>
                    <textarea type="text" name="complaint" id="complaint"
                        class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Type complaint reason here" required></textarea>
                </div>
                <div class="col-span-2">
                    <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900">Remarks </label>
                    <textarea type="text" name="remarks" id="remarks"
                        class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Type remarks here"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end w-full gap-3 mt-6">
                <button type="button" onclick="hideAddReportModal()"
                    class="flex justify-center w-full px-4 py-3 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-300 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 sm:w-auto">
                    Close
                </button>
                <button type="submit"
                    class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-green-500 rounded-lg focus:ring-4 focus:outline-none focus:ring-green-300 hover:bg-green-600 bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>