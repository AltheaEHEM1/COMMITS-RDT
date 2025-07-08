@extends('layouts.app-layout')

@section('title', 'Reports')

@section('content')

    {{--  gets the filter queries --}}
    @php
        $filters = [];

        // Check if a category is selected and add it (capitalize the first letter)
        if (request()->has('category') && request()->query('category') !== '') {
            $filters[] = ucfirst(request()->query('category'));
        }

        // Check if a month is selected; convert the numeric month to its full name
        if (request()->has('month') && request()->query('month') !== '') {
            $monthNumber = (int) request()->query('month');
            // Use DateTime to convert month number to full month name
            $filters[] = DateTime::createFromFormat('!m', $monthNumber)->format('F');
        }

        $filterDisplay = count($filters) ? implode(', ', $filters) : 'None';
    @endphp

    <div class="container mx-auto">
        <x-page-title class="mb-2" value="Reports" />

        <!-- <div class="flex flex-wrap items-center justify-end w-full gap-2 mb-4">

            @if ($filterDisplay !== 'None')
                <p class="items-start flex-grow text-gray-500">
                    Filter: {{ $filterDisplay }}
                </p>
            @endif

            {{-- filter by category --}}
            <div class="relative">
                <button id="categoryFilterButton"
                    class="flex items-center justify-center gap-2 px-4 py-2.5 text-gray-500 bg-gray-200 hover:bg-gray-300 rounded-lg transition-all duration-200 "
                    onclick="toggleDropdown()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 32 25" fill="none">
                        <path
                            d="M29.815,6.168C29.484,5.448,28.783,5,27.986,5H4.014c-0.797,0-1.498,0.448-1.83,1.168 c-0.329,0.714-0.215,1.53,0.297,2.128c0,0,0.001,0.001,0.001,0.001L12,19.371V28c0,0.369,0.203,0.708,0.528,0.882 C12.676,28.961,12.838,29,13,29c0.194,0,0.387-0.057,0.555-0.168l6-4C19.833,24.646,20,24.334,20,24v-4.629l9.519-11.074 C30.031,7.698,30.145,6.882,29.815,6.168z"
                            fill="currentColor"></path>
                    </svg>
                    Filter
                </button> -->

    <div class="p-4 bg-white rounded-lg shadow">
  <!-- Top bar with tabs on left and button(s) on right -->
<div class="flex flex-wrap justify-between items-center mb-3 gap-4">
    
    <!-- Tabs -->
    <div class="flex flex-wrap gap-2">
        <a class="px-3 py-2 text-base text-gray-800 border-b-2 border-blue-500 rounded-t bg-blue-50 tab-btn whitespace-nowrap activate hover:text-gray-700"
            href="{{ route('reports.index') }}">All</a>

        <a class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
            href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'Students'])) }}">Students</a>

        <a class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
            href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'Faculty'])) }}">Faculty</a>

        <a class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
            href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'Admin'])) }}">Administrative</a>

        <a class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
            href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'Visitors'])) }}">Visitors</a>

        <a class="px-3 py-2 text-base text-gray-500 border-b-2 border-gray-300 rounded tab-btn whitespace-nowrap hover:text-gray-700"
            href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'Dependents'])) }}">Dependents</a>
    </div>

   <!-- Buttons aligned to the right -->
    <div class="flex gap-2 ml-auto">
        <form action="{{ route('reports.showReportPaper') }}" method="GET">
            <button type="submit"
                class="relative flex flex-col items-center px-3 py-2 font-bold text-blue-500 bg-blue-100 rounded-lg group hover:bg-blue-200 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span
                    class="absolute bottom-[-1.5rem] left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white font-normal text-gray-700 px-4 text-sm py-1 rounded-md shadow">
                    Print
                </span>
            </button>
        </form>



        <!-- <div class="flex gap-2">

                   <form action="{{ route('reports.showReportPaper') }}" method="GET">
                <button type="submit"
                    class="relative flex flex-col items-center px-3 py-2 space-y-1 font-bold text-blue-500 bg-blue-100 rounded-lg group hover:bg-blue-200 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    <span
                        class="absolute bottom-[-1.5rem] left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white font-normal text-gray-700 px-4 text-sm py-1 rounded-md shadow">
                        Print
                    </span>
                </button>
            </form> -->

                <!-- <div id="categoryFilterDropdown" class="absolute z-50 hidden mt-1 bg-white border rounded-md shadow-lg ">
                    <ul class="w-full">
                        <li><a class="block px-6 py-2 font-normal text-gray-700 hover:bg-gray-100 hover:text-gray-700"
                                href="{{ route('reports.index') }}">All</a></li>
                        <li><a class="block px-6 py-2 font-normal text-gray-700 hover:bg-gray-100 hover:text-gray-700"
                                href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'students'])) }}">Students</a>
                        </li>
                        <li><a class="block px-6 py-2 font-normal text-gray-700 hover:bg-gray-100 hover:text-gray-700"
                                href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'faculty'])) }}">Faculty</a>
                        </li>
                        <li><a class="block px-6 py-2 font-normal text-gray-700 hover:bg-gray-100 hover:text-gray-700"
                                href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'admin'])) }}">Admin</a>
                        </li>
                        <li><a class="block px-6 py-2 font-normal text-gray-700 hover:bg-gray-100 hover:text-gray-700"
                                href="{{ route('reports.index', array_merge(request()->query(), ['category' => 'visitors'])) }}">Visitors</a>
                        </li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('reports.showReportPaper') }}" method="GET">
                <button type="submit"
                    class="relative flex flex-col items-center px-3 py-2 space-y-1 font-bold text-blue-500 bg-blue-100 rounded-lg group hover:bg-blue-200 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    <span
                        class="absolute bottom-[-1.5rem] left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white font-normal text-gray-700 px-4 text-sm py-1 rounded-md shadow">
                        Print
                    </span>
                </button>
            </form> -->

            <!-- Add Button -->
            <button
                class="inline-flex items-center gap-2 px-3 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg active:shadow-sm transform active:translate-y-0"
                onclick="showAddReportModal()">
                                <span class="font-medium">+ Add Report</span>
            </button>
        </div>

        <!-- Responsive Table -->
        <div class="mt-4"></div>

            @if (count($reports) > 0)
                <div class="overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full text-sm text-left text-black-500">
                        <thead class="text-xs bg-gray-100 uppercase border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Age</th>
                                <th class="px-6 py-3">Sex</th>
                                <th class="px-6 py-3">Complaint/Reason</th>
                                <th class="px-6 py-3">Diagnosis</th>
                                <th class="px-6 py-3">Remarks</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            @foreach ($reports as $report)
                                <tr class="bg-white border-b hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $report->title }}</td>
                                    <td class="px-4 py-2">{{ $report->name }}</td>
                                    <td class="px-4 py-2">{{ $report->age }}</td>
                                    <td class="px-4 py-2">{{ $report->sex }}</td>
                                    <td class="px-4 py-2">{{ $report->complaint }}</td>
                                    <td class="px-4 py-2">{{ $report->diagnosis }}</td>
                                    <td class="px-4 py-2">{{ $report->remarks }}</td>
                                    <td class="px-4 py-2">{{ $report->category }}</td>
                                    <td class="flex px-4 py-2 gap-x-2">
                                        <button onclick='showEditReportModal(@json($report->toArray()))'
                                            class="px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('reports.destroy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="report_id" value="{{ $report->id }}"
                                                name="id">
                                            <button type="button"
                                                onclick="confirmDelete('{{ $report->title }}', this.form)"
                                                class="px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <p class="text-xl text-gray-600">No reports available.</p>
                    <p class="mt-2 text-gray-500">Click on "Add Report" to create your first report.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- Add Report Modal -->
    @include('reports.create')

    <!-- Edit Report Modal -->
    @include('reports.edit')

@endsection

@push('scripts')
    <script>
        function toggleDropdown() {
            document.getElementById('categoryFilterDropdown').classList.toggle('hidden');
        }

        // Hide dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = ['categoryFilterDropdown', 'dateFilterDropdown'];
            dropdowns.forEach(id => {
                const dropdown = document.getElementById(id);
                const button = document.getElementById(id.replace('Dropdown', 'Button'));
                if (dropdown && !dropdown.classList.contains('hidden') && !dropdown.contains(event
                        .target) && !button.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        function showAddReportModal() {
            let modal = document.getElementById("addReportModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
        }

        function hideAddReportModal() {
            let modal = document.getElementById("addReportModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        function showEditReportModal(report) {
            let modal = document.getElementById("editReportModal");
            let modalContent = modal.querySelector("div.relative");
            let form = document.getElementById('editReportForm');

            form.querySelector('#report_id').value = report.id;
            form.querySelector('#title').value = report.title;
            form.querySelector('#name').value = report.name;
            form.querySelector('#age').value = report.age;
            form.querySelector('#sex').value = report.sex;
            form.querySelector('#complaint').value = report.complaint;
            form.querySelector('#diagnosis').value = report.diagnosis;
            form.querySelector('#remarks').value = report.remarks;
            form.querySelector('#category').value = report.category;

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
        }

        function hideEditReportModal() {
            let modal = document.getElementById("editReportModal");
            let modalContent = modal.querySelector("div.relative");
            let form = document.getElementById('editReportForm');

            form.querySelector('#report_id').value = "";
            form.querySelector('#title').value = "";
            form.querySelector('#name').value = "";
            form.querySelector('#age').value = "";
            form.querySelector('#sex').value = "";
            form.querySelector('#complaint').value = "";
            form.querySelector('#diagnosis').value = "";
            form.querySelector('#remarks').value = "";
            form.querySelector('#category').value = "";

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        function confirmDelete(title, form) {
            Swal.fire({
                title: "Warning!",
                html: "Are you sure you want to delete this report with title: <strong>" + title + "</strong>?",
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