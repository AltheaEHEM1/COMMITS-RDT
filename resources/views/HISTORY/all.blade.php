@extends('layouts.app-layout')

@section('title', 'History')

@section('content')
    <div class="container px-4 mx-auto">
        <x-page-title class="mb-2" value="History" />

        <div class="w-full mb-3">
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">
                <!-- Search Form (Left-aligned) -->
                <div class="w-full md:w-96">
                    <form action="{{ route('History.all') }}" method="GET" class="m-0">
                        <!-- Preserve existing filters when searching -->
                        @if(request()->has('month'))
                            <input type="hidden" name="month" value="{{ request('month') }}">
                        @endif
                        @if(request()->has('week'))
                            <input type="hidden" name="week" value="{{ request('week') }}">
                        @endif
                        
                        <label for="topbar-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="topbar-search"
                                class="bg-gray-200 border h-11 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 pr-16 py-2.5 truncate"
                                placeholder="Search patient name, ID..." 
                                value="{{ $searchTerm ?? '' }}" />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <button type="submit" class="p-1 mr-1 rounded-full focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                    <svg class="w-5 h-5 text-gray-500 hover:text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                @if(request()->has('search'))
                                    <a href="{{ route('History.all', array_filter(request()->except('search'))) }}" 
                                       class="p-1 rounded-full focus:outline-none focus:shadow-outline hover:bg-gray-100"
                                       title="Clear search">
                                        <svg class="w-5 h-5 text-gray-500 hover:text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if($searchTerm ?? false)
                            <div class="mt-1 text-xs text-gray-600">
                                Searching for: <span class="font-medium">{{ $searchTerm }}</span>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Filter Dropdowns (Right-aligned) -->
                <div class="flex flex-wrap items-center justify-end gap-2">
                    <!-- Month Dropdown -->
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown('month-dropdown')"
                            class="flex items-center px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-all duration-200">
                            <p class="px-2">{{ $selectedMonth ?? 'All Month' }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                viewBox="0 0 24 24">
                                <path d="M7 10l5 5 5-5H7z" />
                            </svg>
                        </button>
                        <div id="month-dropdown"
                            class="absolute right-0 hidden w-40 mt-2 bg-white border border-gray-200 rounded shadow-lg dropdown-content">
                            <ul class="py-1">
                                <!-- All Months -->
                                <li>
                                    <a href="{{ route('History.all', request()->only('search')) }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">All</a>
                                </li>
                                @foreach ($months as $month)
                                    <li>
                                        <a href="{{ route('History.all', array_merge(request()->only('search'), ['month' => $month])) }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ $month }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Section -->
        <div class="w-full">
            <!-- Grouping Records by Date -->
            @php
                $sortedRecords = $records->sortByDesc('updated_at');
                $groupedRecords = $sortedRecords->groupBy(function ($record) {
                    return \Carbon\Carbon::parse($record->created_at)->format('l, F j, Y'); // Format by full date
                });
            @endphp

            @if ($groupedRecords->isEmpty())
                <p class="text-center text-gray-600">No records found.</p>
            @else
                <div class="space-y-6">
                    @foreach ($groupedRecords as $date => $dateRecords)
                        <div class="w-full">
                            <div class="w-full max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-700">{{ $date }}</h2>
                                <ul class="space-y-3">
                                    @foreach ($dateRecords as $record)
                                        <li class="flex items-center space-x-4 history-item">
                                            <span class="text-sm text-gray-700">
                                                {{ $record->created_at->format('h:i A') }}
                                            </span>
                                            <span class="text-gray-400"> | </span>
                                            <svg class="w-6 h-6 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-md font-normal text-gray-700">{{ $record->fullname }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                if (dropdown.id !== dropdownId) dropdown.classList.remove('show');
            });
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => dropdown.classList.remove('show'));
            }
        };
    </script>
@endsection