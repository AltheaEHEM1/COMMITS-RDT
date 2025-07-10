@extends('layouts.app-layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full">
                <h2 class="mb-3 text-2xl font-semibold text-gray-800">Dashboard</h2>
                <form action="#" method="GET" class="flex items-center justify-start mb-4">
                    <div class="w-full md:w-96">
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
                                   placeholder="Search patients, reports, medicines..." 
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
                                    <a href="{{ url()->current() }}" 
                                       class="p-1 rounded-full focus:outline-none focus:shadow-outline hover:bg-gray-100"
                                       title="Clear search">
                                        <svg class="w-5 h-5 text-gray-500 hover:text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if(request()->has('search'))
                            <div class="mt-1 text-xs text-gray-600">
                                Searching for: <span class="font-medium">{{ request('search') }}</span>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results Section -->
        @if(isset($searchResults) && $searchTerm)
            <div class="mb-8 overflow-hidden bg-white border shadow-lg rounded-xl">
                @if(!$searchResults['hasResults'])
                    <!-- No results state -->
                    <div class="flex flex-col items-center justify-center p-12">
                        <div class="p-4 mb-4 bg-gray-100 rounded-full">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 14h.01M5.8 21h12.4a2 2 0 002-2V5a2 2 0 00-2-2H5.8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-xl font-medium text-gray-700">No results found</p>
                        <p class="mt-2 text-sm text-gray-500">Try adjusting your search terms or browse categories below</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        <!-- Patients Section -->
                        @if($searchResults['patients']->count() > 0)
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 mr-3 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-800">
                                        Patients <span class="ml-2 text-sm font-normal text-gray-500">({{ $searchResults['patients']->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($searchResults['patients'] as $patient)
                                        <div class="p-4 transition-shadow border border-gray-200 rounded-xl hover:shadow-md bg-gradient-to-br from-white to-gray-50">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $patient->sex === 'Male' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <h5 class="font-medium text-gray-900">{{ $patient->fullName }}</h5>
                                                    <div class="flex flex-wrap gap-2 mt-2">
                                                        @if($patient->student_number)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-medium">
                                                                ID: {{ $patient->student_number }}
                                                            </span>
                                                        @endif
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-gray-800 text-xs font-medium">
                                                            {{ $patient->patientType }}
                                                        </span>
                                                        @if($patient->year_course_dept)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">
                                                                {{ $patient->year_course_dept }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Medicines Section -->
                        @if($searchResults['medicines']->count() > 0)
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 mr-3 bg-yellow-100 rounded-lg">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-800">
                                        Medicines <span class="ml-2 text-sm font-normal text-gray-500">({{ $searchResults['medicines']->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($searchResults['medicines'] as $medicine)
                                        <div class="p-4 transition-shadow border border-gray-200 rounded-xl hover:shadow-md bg-gradient-to-br from-white to-gray-50">
                                            <h5 class="font-medium text-gray-900">{{ $medicine->medicine_name }}</h5>
                                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <span>{{ $medicine->formattedQuantity }}</span>
                                            </div>
                                            <div class="mt-1 flex items-center text-sm {{ Carbon\Carbon::parse($medicine->expiration_date) < now() ? 'text-red-500' : 'text-gray-500' }}">
                                                <svg class="w-4 h-4 mr-1 {{ Carbon\Carbon::parse($medicine->expiration_date) < now() ? 'text-red-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Expires: {{ $medicine->formattedExpiry }}</span>
                                            </div>
                                            <div class="flex items-center justify-between mt-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $medicine->status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $medicine->status }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Supplies Section -->
                        @if($searchResults['supplies']->count() > 0)
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 mr-3 bg-green-100 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-800">
                                        Supplies <span class="ml-2 text-sm font-normal text-gray-500">({{ $searchResults['supplies']->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($searchResults['supplies'] as $supply)
                                        <div class="p-4 transition-shadow border border-gray-200 rounded-xl hover:shadow-md bg-gradient-to-br from-white to-gray-50">
                                            <h5 class="font-medium text-gray-900">{{ $supply->supply_name }}</h5>
                                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <span>{{ $supply->formattedQuantity }}</span>
                                            </div>
                                            <div class="mt-1 flex items-center text-sm {{ Carbon\Carbon::parse($supply->expiration_date) < now() ? 'text-red-500' : 'text-gray-500' }}">
                                                <svg class="w-4 h-4 mr-1 {{ Carbon\Carbon::parse($supply->expiration_date) < now() ? 'text-red-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Expires: {{ $supply->formattedExpiry }}</span>
                                            </div>
                                            <div class="flex items-center justify-between mt-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $supply->status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $supply->status }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Reports Section -->
                        @if($searchResults['reports']->count() > 0)
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 mr-3 bg-indigo-100 rounded-lg">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-800">
                                        Reports <span class="ml-2 text-sm font-normal text-gray-500">({{ $searchResults['reports']->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @foreach($searchResults['reports'] as $report)
                                        <div class="p-4 transition-shadow border border-gray-200 rounded-xl hover:shadow-md bg-gradient-to-br from-white to-gray-50">
                                            <div class="flex items-start justify-between">
                                                <h5 class="font-medium text-gray-900">{{ $report->title }}</h5>
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $report->category }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-600">Patient: <span class="font-medium">{{ $report->patientInfo }}</span></p>
                                            <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $report->complaintPreview }}</p>
                                            <p class="mt-2 text-xs text-gray-400">{{ $report->formattedDate }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Documents Section -->
                        @if($searchResults['documents']->count() > 0)
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 mr-3 bg-purple-100 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-800">
                                        Documents <span class="ml-2 text-sm font-normal text-gray-500">({{ $searchResults['documents']->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @foreach($searchResults['documents'] as $document)
                                        <div class="p-4 transition-shadow border border-gray-200 rounded-xl hover:shadow-md bg-gradient-to-br from-white to-gray-50">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    @switch($document->document_type)
                                                        @case('excuseletter')
                                                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                                                <svg class="text-green-500 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </div>
                                                            @break
                                                        @case('medical_certificate')
                                                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                                                <svg class="text-blue-500 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                                </svg>
                                                            </div>
                                                            @break
                                                        @default
                                                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                                                                <svg class="text-purple-500 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                    @endswitch
                                                </div>
                                                <div class="ml-4">
                                                    <h5 class="font-medium text-gray-900">{{ $document->documentTypeFormatted }}</h5>
                                                    @if($document->patientName)
                                                        <p class="mt-1 text-sm text-gray-600">Patient: <span class="font-medium">{{ $document->patientName }}</span></p>
                                                    @endif
                                                    @if($document->doctorName)
                                                        <p class="text-sm text-gray-500">Doctor: {{ $document->doctorName }}</p>
                                                    @endif
                                                    <p class="mt-1 text-xs text-gray-400">{{ isset($document->documentDate) ? $document->documentDate : $document->formattedDate }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Rectangle 1 -->
            <div class="flex items-center justify-center p-4 space-x-3 bg-white rounded-lg shadow-md min-w-fit">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center text-blue-500 rounded-full bg-blue-50 w-14 h-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-4xl font-semibold">{{ $totalPatients }}</p>
                    <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Patient Records</h2>
                </div>
            </div>

            <!-- Rectangle 2 -->
            <div class="flex items-center justify-center p-4 space-x-3 bg-white rounded-lg shadow-md min-w-fit">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center text-green-500 rounded-full bg-green-50 w-14 h-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-receipt" viewBox="0 0 16 16">
                            <path
                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z" />
                            <path
                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-4xl font-semibold">{{ $totalDocuments }}</p>
                    <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Documents</h2>
                </div>
            </div>

            <!-- Rectangle 3 -->
            <div class="flex items-center justify-center p-4 space-x-3 bg-white rounded-lg shadow-md min-w-fit">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center text-indigo-500 rounded-full bg-indigo-50 w-14 h-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
                            <path d="M6 12v-2h3v2z" />
                            <path
                                d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-4xl font-semibold">{{ $totalReports }}</p>
                    <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Reports</h2>
                </div>
            </div>

            <!-- Rectangle 4 -->
            <div class="flex items-center justify-center p-4 space-x-3 bg-white rounded-lg shadow-md min-w-fit">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center text-yellow-500 rounded-full bg-yellow-50 w-14 h-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-capsule" viewBox="0 0 16 16">
                            <path
                                d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-4xl font-semibold">{{ $totalMedicines }}</p>
                    <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Medicines</h2>
                </div>
            </div>
        </div>

        <!--Total Patients Graph-->
        <div class="flex justify-center mt-12">
            <div class="w-full">
                <h2 class="mb-4 text-xl font-medium text-gray-800">Total Patients</h2>
                <div class="p-6 bg-white border rounded-lg shadow-md">
                    <canvas id="patientsChart" class="w-full h-64 md:h-96 lg:h-128"></canvas>
                </div>
            </div>
        </div>

        <!-- New Section: Types of Patient -->
        <div class="flex justify-center mt-6 md:mt-8">
            <div class="w-full">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Pie Chart Column -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Types of Patient</h2>
                        <div class="relative h-[220px] sm:h-[240px] md:h-[260px] lg:h-[280px] xl:h-[320px]">
                            @if (array_sum($patientCounts) === 0)
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="w-20 h-20 mb-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="text-xl font-semibold text-center text-gray-700">No Patient Records Yet</p>
                                    <p class="mt-2 text-base text-center text-gray-500">Patient data will appear here once
                                        available.</p>
                                </div>
                            @endif
                            <canvas id="typesOfPatientChart"></canvas>
                        </div>
                    </div>

                    <!-- Patient Distribution Column -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Patient Distribution</h2>
                        <div class="flex flex-col space-y-2">
                            <!-- Students -->
                            <div
                                class="p-2 transition-all duration-300 border rounded-lg bg-blue-50 bg-gradient-to-r from-blue-50 to-white hover:shadow-md hover:border-blue-500">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-blue-200 rounded-full">
                                            <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-semibold text-gray-700">Students</h3>
                                            <p class="text-xs text-gray-500">Active Patients</p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-blue-500">{{ $patientCounts['students'] }}</p>
                                </div>
                            </div>

                            <!-- Repeat the same pattern for other patient types (Faculty, Dependents, Staff, Visitors) -->
                            <!-- Faculty -->
                            <div
                                class="p-2 transition-all duration-300 border rounded-lg bg-green-50 bg-gradient-to-r from-green-50 to-white hover:shadow-md hover:border-green-500">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-green-200 rounded-full">
                                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-semibold text-gray-700">Faculty</h3>
                                            <p class="text-xs text-gray-500">Teaching Staff</p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-green-500">{{ $patientCounts['faculty'] }}</p>
                                </div>
                            </div>

                            <!-- Dependents -->
                            <div
                                class="p-2 transition-all duration-300 border rounded-lg bg-red-50 bg-gradient-to-r from-red-50 to-white hover:shadow-md hover:border-red-500">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-red-200 rounded-full">
                                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 006 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-semibold text-gray-700">Dependents</h3>
                                            <p class="text-xs text-gray-500">Family Members</p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-red-500">{{ $patientCounts['dependents'] }}</p>
                                </div>
                            </div>

                            <!-- Staff -->
                            <div
                                class="p-2 transition-all duration-300 border rounded-lg bg-yellow-50 bg-gradient-to-r from-yellow-50 to-white hover:shadow-md hover:border-yellow-500">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-yellow-200 rounded-full">
                                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                <path fill-rule="evenodd"
                                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-semibold text-gray-700">Staff</h3>
                                            <p class="text-xs text-gray-500">Support Personnel</p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-yellow-500">{{ $patientCounts['admin'] }}</p>
                                </div>
                            </div>

                            <!-- Visitors -->
                            <div
                                class="p-2 transition-all duration-300 border rounded-lg bg-purple-50 bg-gradient-to-r from-purple-50 to-white hover:shadow-md hover:border-purple-500">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-purple-200 rounded-full">
                                            <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-semibold text-gray-700">Visitors</h3>
                                            <p class="text-xs text-gray-500">Guest Patients</p>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-purple-500">{{ $patientCounts['visitors'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this before the closing </div> of the container -->
        <div class="flex justify-center mt-6 md:mt-8">
            <div class="w-full">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Left Column: Pie Chart -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Returned Medicines</h2>
                        <div class="relative h-[220px] sm:h-[240px] md:h-[260px] lg:h-[280px] xl:h-[320px]">
                            @if ($medicineStatus['returned'] + $medicineStatus['active'] === 0)
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="w-20 h-20 mb-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="text-xl font-semibold text-center text-gray-700">No Medicine Records Yet</p>
                                    <p class="mt-2 text-base text-center text-gray-500">Medicines data will appear here
                                        once available.</p>
                                </div>
                            @endif
                            <canvas id="returnedMedicineChart"></canvas>
                        </div>
                    </div>

                    <!-- Right Column: Horizontal Bar Graph -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Top Medicines Consumed</h2>
                        <div class="relative h-[220px] sm:h-[240px] md:h-[260px] lg:h-[280px] xl:h-[320px]">
                            <canvas id="topMedicinesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this after your previous charts section -->
        <div class="flex justify-center mt-6 md:mt-8">
            <div class="w-full">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Left Column: Supplies Pie Chart -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Supplies Status</h2>
                        <div class="relative h-[220px] sm:h-[240px] md:h-[260px] lg:h-[280px] xl:h-[320px]">
                            @if ($suppliesStatus['initial'] + $suppliesStatus['consumed'] === 0)
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="w-20 h-20 mb-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="text-xl font-semibold text-center text-gray-700">No Supplies Records Yet</p>
                                    <p class="mt-2 text-base text-center text-gray-500">Supplies data will appear here once
                                        available.</p>
                                </div>
                            @endif
                            <canvas id="suppliesChart"></canvas>
                        </div>
                    </div>

                    <!-- Right Column: Equipment Vertical Bar Graph -->
                    <div class="p-3 bg-white border rounded-lg shadow-md md:p-4">
                        <h2 class="mb-2 text-lg font-medium text-gray-800">Equipment Status</h2>
                        <div class="relative h-[220px] sm:h-[240px] md:h-[260px] lg:h-[280px] xl:h-[320px]">
                            <canvas id="equipmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        // Add this before creating the charts
        Chart.register(ChartDataLabels);
        Chart.defaults.set('plugins.datalabels', {
            color: '#000000',
            font: {
                weight: 'semibold',
                size: 14
            },
            formatter: function(value, context) {
                return value;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('patientsChart').getContext('2d');
            var patientsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Total Patients',
                        data: @json($monthlyPatientCounts),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)', // Consistent blue shade
                            'rgba(75, 192, 192, 0.7)', // Turquoise
                            'rgba(255, 205, 86, 0.7)', // Yellow
                            'rgba(255, 99, 132, 0.7)', // Pink
                            'rgba(153, 102, 255, 0.7)', // Purple
                            'rgba(255, 159, 64, 0.7)', // Orange
                            'rgba(54, 162, 235, 0.7)', // Repeat pattern
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1.5,
                        borderRadius: 8,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8,
                        minBarLength: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1F2937',
                            bodyColor: '#1F2937',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                title: function(tooltipItems) {
                                    var monthNames = ['January', 'February', 'March', 'April', 'May',
                                        'June', 'July', 'August', 'September', 'October',
                                        'November', 'December'
                                    ];
                                    return monthNames[tooltipItems[0].dataIndex];
                                },
                                label: function(context) {
                                    return `Total Patients: ${context.raw}`;
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 4,
                            color: '#4B5563',
                            font: {
                                weight: '600',
                                size: 11
                            },
                            formatter: function(value) {
                                // Check screen width
                                if (window.innerWidth < 768) { // 768px is typical md breakpoint
                                    return value === 0 ? '0' : value; // Just show numbers on mobile
                                }
                                if (value === 0) return 'No Patients';
                                return value;
                            },
                            textStrokeColor: 'white',
                            textStrokeWidth: 2,
                            textShadowBlur: 3,
                            textShadowColor: 'white'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(107, 114, 128, 0.1)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#6B7280',
                                padding: 8
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value, index) {
                                    var screenWidth = window.innerWidth;
                                    var monthAbbreviations = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                                    ];
                                    return screenWidth < 1268 ? monthAbbreviations[index] : this
                                        .getLabelForValue(value);
                                },
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                color: '#374151',
                                padding: 8
                            }
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'easeInOutQuad',
                            from: 1,
                            to: 0,
                            loop: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            right: 16,
                            bottom: 8,
                            left: 8
                        }
                    }
                }
            });


            // Pie Chart for Types of Patient
            var typesCtx = document.getElementById('typesOfPatientChart').getContext('2d');

            // Check if all values are 0
            const hasData = [
                {{ $patientCounts['students'] }},
                {{ $patientCounts['faculty'] }},
                {{ $patientCounts['dependents'] }},
                {{ $patientCounts['admin'] }},
                {{ $patientCounts['visitors'] }}
            ].some(value => value > 0);

            if (!hasData) {
                // Display "No Patient Records Yet" message
                typesCtx.font = 'bold 16px Arial';
                typesCtx.textAlign = 'center';
                typesCtx.textBaseline = 'middle';
                typesCtx.fillStyle = '#6B7280'; // Gray-500 color
            } else {
                // Create the pie chart as normal
                var typesOfPatientChart = new Chart(typesCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Students', 'Faculty', 'Dependents', 'Administrative', 'Visitors'],
                        datasets: [{
                            data: [
                                {{ $patientCounts['students'] }},
                                {{ $patientCounts['faculty'] }},
                                {{ $patientCounts['dependents'] }},
                                {{ $patientCounts['admin'] }},
                                {{ $patientCounts['visitors'] }}
                            ],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(34, 197, 94, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 5,
                                bottom: 5,
                                left: 5,
                                right: 5
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                align: 'center',
                                labels: {
                                    padding: 8,
                                    boxWidth: 10,
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            // Add this new datalabels plugin configuration
                            datalabels: {
                                color: '#000000',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    // Only show label if percentage is greater than 0
                                    return percentage > 0 ? percentage + '%' : '';
                                },
                                display: function(context) {
                                    // Hide label if value is 0
                                    return context.dataset.data[context.dataIndex] > 0;
                                },
                                offset: 0,
                                padding: 0
                            }
                        }
                    }
                });
            }

            // Returned Medicines Pie Chart
            var returnedMedicineChartCtx = document.getElementById('returnedMedicineChart').getContext('2d');
            const hasMedicineData = {{ $medicineStatus['returned'] + $medicineStatus['active'] }} > 0;

            if (!hasMedicineData) {
                // Display "No Medicine Records Yet" message
                returnedMedicineChartCtx.font = 'bold 16px Arial';
                returnedMedicineChartCtx.textAlign = 'center';
                returnedMedicineChartCtx.textBaseline = 'middle';
                returnedMedicineChartCtx.fillStyle = '#6B7280';
            } else {
                var returnedMedicineChart = new Chart(returnedMedicineChartCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Active Medicines', 'Returned Medicines'],
                        datasets: [{
                            data: [
                                {{ $medicineStatus['active'] }},
                                {{ $medicineStatus['returned'] }}
                            ],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)', // green for active
                                'rgba(239, 68, 68, 0.8)' // red for returned
                            ],
                            borderColor: [
                                'rgba(34, 197, 94, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 8,
                                    boxWidth: 10,
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#FFFFFF',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return percentage > 0 ? percentage + '%' : '';
                                },
                                display: function(context) {
                                    return context.dataset.data[context.dataIndex] > 0;
                                }
                            }
                        }
                    }
                });
            }

            // Medicines Horizontal Bar Chart
            var topMedicinesChartCtx = document.getElementById('topMedicinesChart').getContext('2d');
            var topMedicinesChart = new Chart(topMedicinesChartCtx, {
                type: 'bar',
                data: {
                    labels: @json($medicineNames),
                    datasets: [{
                        axis: 'y',
                        data: @json($medicineQuantities),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(201, 203, 207, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(145, 232, 225, 0.6)',
                            'rgba(255, 182, 193, 0.6)',
                            'rgba(128, 128, 128, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(201, 203, 207, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(145, 232, 225, 1)',
                            'rgba(255, 182, 193, 1)',
                            'rgba(128, 128, 128, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 4,
                        minBarLength: 10 // Add this to show minimum bar length for zero values
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.raw === 0) return 'No consumption';
                                    return `Consumed: ${context.raw} ${@json($medicineUnits)[context.dataIndex]}`;
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'right',
                            color: '#000000',
                            font: {
                                weight: 'bold',
                                size: 10
                            },
                            formatter: function(value, context) {
                                if (value === 0) return 'Empty Data';
                                return `${value} ${@json($medicineUnits)[context.dataIndex]}`;
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value, index) {
                                    const label = @json($medicineNames)[index];
                                    if (label === 'No Medicine') return '';
                                    return this.getLabelForValue(value);
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 30,
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });

            // Supplies Pie Chart
            var suppliesInitial = {{ $suppliesStatus['initial'] }};
            var suppliesConsumed = {{ $suppliesStatus['consumed'] }};
            var suppliesHasData = suppliesInitial + suppliesConsumed > 0;

            if (!suppliesHasData) {
                // Optionally, you can show a message or just do nothing (the Blade already shows a message)
                // You may also clear the canvas if needed:
                var suppliesCtx = document.getElementById('suppliesChart').getContext('2d');
                suppliesCtx.clearRect(0, 0, suppliesCtx.canvas.width, suppliesCtx.canvas.height);
            } else {
                var suppliesCtx = document.getElementById('suppliesChart').getContext('2d');
                var suppliesChart = new Chart(suppliesCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Available', 'Consumed'],
                        datasets: [{
                            data: [suppliesInitial, suppliesConsumed],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)', // green for initial
                                'rgba(239, 68, 68, 0.8)' // red for consumed
                            ],
                            borderColor: [
                                'rgba(34, 197, 94, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 8,
                                    boxWidth: 10,
                                    font: {
                                        size: 10
                                    }
                                },
                                display: suppliesHasData // Hide legend if no data
                            },
                            tooltip: {
                                enabled: suppliesHasData, // Hide tooltip if no data
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#FFFFFF',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return percentage > 0 ? `${percentage}%` : '';
                                },
                                display: function(context) {
                                    // Hide datalabels if value is 0 or all data is zero
                                    return suppliesHasData && context.dataset.data[context.dataIndex] > 0;
                                }
                            }
                        }
                    }
                });
            }

            // Equipment Vertical Bar Chart
            var equipmentCtx = document.getElementById('equipmentChart').getContext('2d');
            var equipmentChart = new Chart(equipmentCtx, {
                type: 'bar',
                data: {
                    labels: ['Serviceable', 'For Repair', 'For Condemn', 'Need Replacement'],
                    datasets: [{
                        data: [
                            {{ $equipmentStatus['serviceable'] }},
                            {{ $equipmentStatus['for_repair'] }},
                            {{ $equipmentStatus['for_condemn'] }},
                            {{ $equipmentStatus['need_replacement'] }}
                        ],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.7)', // Lighter green
                            'rgba(234, 179, 8, 0.7)', // Lighter yellow
                            'rgba(239, 68, 68, 0.7)', // Lighter red
                            'rgba(59, 130, 246, 0.7)' // Lighter blue
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(234, 179, 8, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(59, 130, 246, 1)'
                        ],
                        borderWidth: 1.5,
                        borderRadius: 8,
                        barPercentage: 0.6, // Make bars thinner
                        categoryPercentage: 0.8,
                        minBarLength: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1F2937',
                            bodyColor: '#1F2937',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return `Quantity: ${context.raw} units`;
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 4,
                            color: '#4B5563',
                            font: function(context) {
                                const width = context.chart.width;
                                // Responsive font sizes
                                if (width < 512) {
                                    return {
                                        weight: '600',
                                        size: 9
                                    };
                                } else if (width < 768) {
                                    return {
                                        weight: '600',
                                        size: 10
                                    };
                                } else {
                                    return {
                                        weight: '600',
                                        size: 11
                                    };
                                }
                            },
                            formatter: function(value) {
                                if (value === 0) return 'Empty Data';
                                return value + ' units';
                            },
                            textStrokeColor: 'white',
                            textStrokeWidth: 2,
                            textShadowBlur: 3,
                            textShadowColor: 'white'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(107, 114, 128, 0.1)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#6B7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: function(context) {
                                    const width = context.chart.width;
                                    // Responsive font sizes
                                    if (window.innerWidth < 912) {
                                        return {
                                            size: 8,
                                            weight: '500'
                                        };
                                    } else if (window.innerWidth < 1320) {
                                        return {
                                            size: 10,
                                            weight: '500'
                                        };
                                    } else {
                                        return {
                                            size: 12,
                                            weight: '500'
                                        };
                                    }
                                },
                                color: '#374151',
                                callback: function(value, index) {
                                    const labels = ['Serviceable', 'For Repair', 'For Condemn',
                                        'Need Replacement'
                                    ];
                                    const shortLabels = ['Serviceable', 'Repair', 'Condemn',
                                        'Replacement'
                                    ];
                                    const noLabels = ['', '', '', ''];

                                    // Check screen width
                                    if (window.innerWidth < 412) { // 768px is typical md breakpoint
                                        return noLabels[index];
                                    } else if (window.innerWidth <= 1320) {
                                        return shortLabels[index];
                                    }
                                    return labels[index];
                                }
                            }
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'easeInOutQuad',
                            from: 1,
                            to: 0,
                            loop: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            right: 16,
                            bottom: 8,
                            left: 8
                        }
                    }
                }
            });

            // Add resize handler to update labels when screen size changes
            window.addEventListener('resize', function() {
                equipmentChart.update();
            });
        });
    </script>
@endsection
