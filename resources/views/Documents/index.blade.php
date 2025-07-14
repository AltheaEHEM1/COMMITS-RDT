@extends('layouts.app-layout')

@section('title', 'Documents')

@section('content')
    <div class="container mx-auto">
        <x-page-title class="mb-2" value="Documents" />
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-gray-500">Recents</h2>
            <div class="flex flex-wrap items-center justify-end w-full gap-2 mb-4">
                <!-- Filter Dropdown -->
                <div class="relative">
                    <button onclick="openControlNumber()" class="inline-flex items-center gap-1 px-2 py-2.5 text-blue-500 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200">
                        <svg class="w-6 h-6 text-blue-800 dark:text-blue" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z" clip-rule="evenodd"/>
                        </svg>

                    </button>

                </div>
                <div class="relative">
                    <button onclick="toggleDropdown('document-type-dropdown')"
                        class="inline-flex items-center gap-1 px-2 py-2.5 text-blue-500 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200">
                        <p class="px-2">Document Type</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="25" viewBox="0 0 32 25"
                            fill="none">
                            <path
                                d="M15.5993 15.4256L10.1191 11.2891L11.9458 9.91016L15.5993 12.6679L19.2526 9.91016L21.0793 11.2891L15.5993 15.4256Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <div id="document-type-dropdown"
                        class="dropdown-content absolute z-50 right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg hidden">
                        <a href="{{ route('documents.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">All</a>
                        @foreach ($typeOptions as $type)
                            <a href="{{ route('documents.index', ['document_type' => $type]) }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ $type }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="relative">
                    <button onclick="toggleDropdown('date-dropdown')"
                        class="inline-flex items-center gap-1 px-3 py-2.5 text-blue-500 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200">
                        <p class="px-2">Month</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="25" viewBox="0 0 32 25"
                            fill="none">
                            <path
                                d="M15.5993 15.4256L10.1191 11.2891L11.9458 9.91016L15.5993 12.6679L19.2526 9.91016L21.0793 11.2891L15.5993 15.4256Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <div id="date-dropdown"
                        class="dropdown-content absolute z-50 left-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg hidden">
                        @foreach ($MonthOptions as $index => $month)
                            <a href="{{ route('documents.index', ['month' => $index + 1]) }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ $month }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Add Dropdown -->
                <div class="relative inline-block text-left">
                    <button onclick="toggleDropdown('add-dropdown')"
                        class="inline-flex items-center gap-2 px-4 py-2.5 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-all duration-200 transform active:translate-y-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 17 17"
                            fill="none">
                            <path
                                d="M7.35714 9.64286H0.5V7.35714H7.35714V0.5H9.64286V7.35714H16.5V9.64286H9.64286V16.5H7.35714V9.64286Z"
                                fill="white" />
                        </svg>
                        <p class="px-2">Add</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="25" viewBox="0 0 32 25"
                            fill="none">
                            <path
                                d="M15.5993 15.4256L10.1191 11.2891L11.9458 9.91016L15.5993 12.6679L19.2526 9.91016L21.0793 11.2891L15.5993 15.4256Z"
                                fill="#FFFFFF" />
                        </svg>
                    </button>
                    <div id="add-dropdown"
                        class="dropdown-content absolute z-50 right-0 mt-2 w-64 bg-white border border-gray-200 rounded shadow-lg">
                        <a href="{{ route('documents.medical_certificate.create', ['document_type' => 'Medical Certificate']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Medical Certificate</a>
                        <a href="{{ route('documents.medical_clearance.create', ['document_type' => 'Medical Clearance']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Medical Clearance</a>
                        <a href="{{ route('documents.annual_medical_clearance.create', ['document_type' => 'Annual Medical Clearance']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Annual Medical Clearance</a>
                        <a href="{{ route('documents.excuse_letter.create', ['document_type' => 'Excuse Letter']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Excuse Letter</a>
                        <a href="{{ route('documents.waiver.create', ['document_type' => 'Waiver']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Waiver</a>
                        <a href="{{ route('documents.waiver_for_pulmonary_case.create', ['document_type' => 'Waiver for Pulmonary Case']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Waiver for Pulmonary Case</a>
                        <a href="{{ route('documents.dmdc_consent_form.create', ['document_type' => 'DMDC Consent Form']) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">DMDC Consent Form</a>
                    </div>
                </div>
            </div>
        </div>

 <!-- Recents Section -->
<div>
    <table class="min-w-full bg-white rounded-lg shadow relative">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Document</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date Created</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($documents->isEmpty() || $documents->where('deleted_at', '!=', null)->count() === $documents->count())
                <tr>
                    <td colspan="3" class="text-center text-gray-500 font-medium p-4">No Documents Found.</td>
                </tr>
            @else
                @foreach ($documents as $document)
                    <tr class="border-b hover:bg-gray-50 transition-all align-middle">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800 min-h-[56px]">{{ $document->document_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 min-h-[56px]">{{ $document->created_at->format('F j, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center min-h-[56px]">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown('actions-dropdown-{{ $document->id }}')"
                                    class="inline-flex items-center gap-1 p-2 text-gray-700 bg-gray-200 text-sm hover:bg-gray-300 rounded-lg transition-all duration-200">
                                    <span>Actions</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 25" fill="none">
                                        <path d="M15.5993 15.4256L10.1191 11.2891L11.9458 9.91016L15.5993 12.6679L19.2526 9.91016L21.0793 11.2891L15.5993 15.4256Z" fill="currentColor" />
                                    </svg>
                                </button>
                                <div id="actions-dropdown-{{ $document->id }}"
                                    class="dropdown-content text-center text-sm absolute left-0 mt-2 min-w-[7rem] bg-white border border-gray-200 rounded shadow-lg hidden"
                                    style="z-index:99999; min-width:7rem;">
                                    <a href="{{ route('documents.' . strtolower(str_replace(' ', '_', $document->document_type)) . '.view', $document->id) }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View</a>
                                    <a href="{{ route('documents.' . strtolower(str_replace(' ', '_', $document->document_type)) . '.edit', $document->id) }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                                    <form id="delete-document-{{$document->id}}"
                                        action="{{ route('documents.' . strtolower(str_replace(' ', '_', $document->document_type)) . '.delete', $document->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a type="button" onclick="confirmDelete('delete-document-{{$document->id}}')"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Delete</a>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
    <!-- Modal for Control Number -->
    <div id="ControlNumberModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <!-- Modal content -->
    <div class="relative w-full h-full max-w-2xl p-6 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <!-- Modal header -->
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-xl font-bold text-gray-700">Documents Control Number</h3>
            <button type="button" onclick="closeControlNumber()"
                class="inline-flex items-center p-2 ml-auto text-2xl text-red-500 bg-gray-200 rounded-full focus:ring-4 focus:outline-none focus:ring-gray-300 hover:bg-gray-300 hover:text-red-700"
                data-modal-toggle="ControlNumberModal">
                <svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        @if($controlNumber->isEmpty())
            <div class="text-center text-gray-500 font-medium p-4">
                <p>No Control Number Added.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($controlNumber as $control)
                    <div class="border-b pb-2 flex items-center justify-between">
                        <div>
                            <h2 class="text-md font-semibold text-gray-800">{{ $control->document_type }}</h2>
                            <p class="text-gray-700 text-sm">{{ $control->control_number }} | Rev. {{ $control->revision }} | {{ \Carbon\Carbon::parse($control->date_issued)->format('F d, Y') }}</p>
                        </div>
                        <!-- Edit Button -->
                        <a onclick="openEditModal({{ $control->id }})" data-target="#editFormModal{{ $control->id }}" class="hover:bg-blue-100 rounded-md py-2 px-2 inline-flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        @if($allTypesCreated === false)
        <div class="flex justify-end space-x-4 mt-6">
            <button onclick="openCreateForm()" type="button"
                class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                Add
            </button>
        </div>
        @endif
    </div>
</div>


    <!-- Create Form Modal For Controller Number -->
    <div id="createFormModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <div class="relative w-full h-full max-w-2xl p-6 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-xl font-bold text-gray-700">Create Control Number</h3>
            <button type="button" onclick="closeCreateModal()"
                class="inline-flex items-center p-2 ml-auto text-2xl text-red-500 bg-gray-200 rounded-full focus:ring-4 focus:outline-none focus:ring-gray-300 hover:bg-gray-300 hover:text-red-700"
                data-modal-toggle="createFormModal">
                <svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <div id="formContainer" class="space-y-4">
            <form action="{{ route('control-numbers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="block text-gray-600 font-medium mb-1">Document Type: <span class="text-red-500">*</span></label>
                    <select name="document_type"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Document Type</option>
                        <option value="Excuse Letter">Excuse Letter</option>
                        <option value="Annual Medical Clearance">Annual Medical Clearance</option>
                        <option value="Medical Clearance">Medical Clearance</option>
                        <option value="Medical Certificate">Medical Certificate</option>
                        <option value="DMDC Consent Form">DMDC Consent Form</option>
                        <option value="Waiver">Waiver</option>
                        <option value="Waiver for Pulmonary Case">Waiver for Pulmonary Case</option>
                    </select>
                    <span class="text-red-500 text-sm hidden">Document Type is required.</span>
                    <label class="block text-gray-600 font-medium mb-1">Control Number: <span class="text-red-500">*</span></label>
                    <input type="text" id="dateInput"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="control_number" required>
                    <label class="block text-gray-600 font-medium mb-1">Revision No.: <span class="text-red-500">*</span></label>
                    <input type="text" id="dateInput"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="revision" required>
                    <span id="dateError" class="text-red-500 text-sm hidden">Revision No. is required.</span>
                    <label class="block text-gray-600 font-medium mb-1">Date: <span class="text-red-500">*</span></label>
                    <input type="date" id="dateInput"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="date_issued" required>
                    <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button onclick="goBack()" type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Back
                    </button>
                    <button type="submit"
                        class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($controlNumber as $control)
<!-- Edit Form Modal For Controller Number -->
<div id="editFormModal-{{ $control->id }}" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <div class="relative w-full h-full max-w-2xl p-6 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-xl font-bold text-gray-700">Edit Control Number</h3>
            <button type="button" onclick="closeEditModal({{ $control->id }})"
                class="inline-flex items-center p-2 ml-auto text-2xl text-red-500 bg-gray-200 rounded-full focus:ring-4 focus:outline-none focus:ring-gray-300 hover:bg-gray-300 hover:text-red-700"
                data-modal-toggle="editFormModal-{{ $control->id }}">
                <svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <div id="formContainer" class="space-y-4">
            <form action="{{ route('control-numbers.update', $control->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <input type="hidden" name="document_type" value="{{ $control->document_type }}">
                    <label class="block text-gray-800 text-md font-bold mb-1">{{ $control->document_type ?? '' }}</label>
                    <label class="block text-gray-600 font-medium mb-1">Control Number: <span class="text-red-500">*</span></label>
                    <input type="text" id="dateInput" value="{{ old('control_number', $control->control_number ?? '') }}"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="control_number" required>
                    <label class="block text-gray-600 font-medium mb-1">Revision No.: <span class="text-red-500">*</span></label>
                    <input type="text" id="dateInput" value="{{ old('revision', $control->revision ?? '') }}"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="revision" required>
                    <span id="dateError" class="text-red-500 text-sm hidden">Revision No. is required.</span>
                    <label class="block text-gray-600 font-medium mb-1">Date: <span class="text-red-500">*</span></label>
                    <input type="date" id="dateInput" value="{{ old('date_issued', $control->date_issued ?? '') }}"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="date_issued" required>
                    <span id="dateError" class="text-red-500 text-sm hidden">Date is required.</span>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button onclick="goBack2({{ $control->id }})" type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Back
                    </button>
                    <button type="submit"
                        class="bg-[#3CAA38] hover:bg-[#2B8E2F] text-white font-medium py-2 px-4 rounded-md">
                        Save Edit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
    <script>
        function openCreateForm() {
            let modal = document.getElementById("createFormModal");
            let modalContent = modal.querySelector("div.relative, .relative");
            document.getElementById('ControlNumberModal').classList.add('hidden');
            document.body.classList.add('overflow-hidden');
            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10);
            checkAdditionalFields();
        }
        function closeCreateModal() {
            let modal = document.getElementById("createFormModal");
            let modalContent = modal.querySelector("div.relative, .relative");
            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");
            setTimeout(() => {
                modal.classList.add("hidden");
                document.body.classList.remove('overflow-hidden');
            }, 300);
            document.getElementById('ControlNumberModal').classList.remove('hidden');
        }

        function openEditModal(controlId) {
            const modal = document.getElementById('editFormModal-' + controlId);
            document.getElementById('ControlNumberModal').classList.add('hidden');
            document.body.classList.add('overflow-hidden');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    const modalContent = modal.querySelector("div.relative, .relative");
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);
            }
        }

        function closeEditModal(controlId) {
            const modal = document.getElementById('editFormModal-' + controlId);
            if (modal) {
                modal.classList.add('opacity-0');
                const modalContent = modal.querySelector("div.relative, .relative");
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    document.getElementById('ControlNumberModal').classList.remove('hidden');
                    setTimeout(() => {
                        document.getElementById('ControlNumberModal').classList.remove('opacity-0');
                        const mainModalContent = document.getElementById('ControlNumberModal').querySelector("div.relative, .relative");
                        mainModalContent.classList.remove('scale-95');
                        mainModalContent.classList.add('scale-100');
                        document.body.classList.add('overflow-hidden');
                    }, 10);
                }, 300);
            }
        }

        function goBack2(controlId){
            const modal = document.getElementById('editFormModal-' + controlId);
            if (modal) {
                modal.classList.add('hidden');
            }
            document.getElementById('ControlNumberModal').classList.remove('hidden');
        }
        function openControlNumber() {
            let modal = document.getElementById("ControlNumberModal");
            let modalContent = modal.querySelector("div.relative, .relative");
            // Lock scroll and overlay everything
            document.body.classList.add('overflow-hidden');
            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10);
        }
        function closeControlNumber(){
            let modal = document.getElementById("ControlNumberModal");
            let modalContent = modal.querySelector("div.relative, .relative");
            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");
            setTimeout(() => {
                modal.classList.add("hidden");
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }
        // Prevent click outside modal from closing it
        document.getElementById('ControlNumberModal').addEventListener('mousedown', function(e) {
            if (e.target === this) {
                e.stopPropagation();
            }
        });

        function closeCreateForm() {
            let modal = document.getElementById("createFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        function goBack(){
            document.getElementById('createFormModal').classList.add('hidden');
            document.getElementById('ControlNumberModal').classList.remove('hidden');
        }

        function toggleDropdown(dropdownId) {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                if (dropdown.id !== dropdownId) dropdown.classList.remove('show');
            });
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            dropdown.classList.toggle('show');
            if (dropdown.classList.contains('show')) {
                // Position dropdown so it doesn't overflow the bottom
                const rect = dropdown.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                if (rect.bottom > windowHeight) {
                    dropdown.style.top = 'auto';
                    dropdown.style.bottom = '100%';
                    dropdown.style.marginTop = '0';
                    dropdown.style.marginBottom = '0.5rem';
                } else {
                    dropdown.style.top = '';
                    dropdown.style.bottom = '';
                    dropdown.style.marginTop = '0.5rem';
                    dropdown.style.marginBottom = '';
                }
            } else {
                dropdown.style.top = '';
                dropdown.style.bottom = '';
                dropdown.style.marginTop = '';
                dropdown.style.marginBottom = '';
            }
        }

        window.onclick = function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => dropdown.classList.remove('show'));
            }
        };

        function confirmDelete(id) {
            let form = document.getElementById(id);

            Swal.fire({
                title: "Warning!",
                text: "Are you sure you want to delete this document?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: `{!! session('success') !!}`,
                icon: "success"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error!",
                text: `{!! session('error') !!}`,
                icon: "error"
            });
        </script>
    @endif
@endpush
