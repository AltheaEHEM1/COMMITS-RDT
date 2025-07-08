@extends('layouts.app-layout')

@section('content')
    <div class="container flex flex-col mx-auto">
        <x-page-title class="mb-8" value="Inventory" />

        <div class="relative p-4 space-y-4 bg-white rounded-lg shadow">
            <div class="flex flex-col gap-4 sm:gap-8 sm:flex-row sm:items-center sm:justify-between">
                {{-- Tab Links --}}
                <div class="flex flex-col text-center sm:flex-row sm:gap-4">
                    <x-inventory.tab :href="route('inventory-medicines')" :active="request()->is('inventory/medicines*') || request()->is('inventory')">Medicines</x-inventory.tab>
                    <x-inventory.tab
                        :href="route('inventory-supplies')"
                        :active="request()->routeIs('inventory-supplies') || request()->routeIs('supplies.*')">
                        Supplies
                    </x-inventory.tab>
                    <x-inventory.tab :href="route('inventory-equipment')" :active="request()->is('inventory/equipment*')">Equipment</x-inventory.tab>
                </div>

                <div class="flex mb-4 space-x-2">
                    <!-- Filter Button -->
                    <button data-modal-target="filter-modal" data-modal-toggle="filter-modal" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-white border border-gray-300 rounded-md hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-200 disabled:opacity-25" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>

                    <!-- Download Excel Button -->
                    @php
                        $exportType = 'medicines'; // Default
                        if(request()->is('inventory/supplies*')) {
                            $exportType = 'supplies';
                        } elseif(request()->is('inventory/equipment*')) {
                            $exportType = 'equipment';
                        }
                    @endphp
                    <a href="{{ route('inventory.export', $exportType) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-300 disabled:opacity-25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Excel
                    </a>

                    <button data-modal-target="create-{{ Route::currentRouteName() }}" data-modal-toggle="create-{{ Route::currentRouteName() }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg active:shadow-sm transform active:translate-y-0" type="button">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                            <p>Add</p>
                        </div>
                    </button>
                </div>
            </div>

            {{-- Filter Modal --}}
            <div id="filter-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Filter Options
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="filter-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            @php
                                $filters = $filters ?? [];
                                $hasActiveFilters = !empty(array_filter($filters));
                            @endphp
                            
                            @if($hasActiveFilters)
                                <div class="p-3 mb-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-blue-800">Active Filters:</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($filters as $key => $value)
                                            @if($value)
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <form id="filter-form" method="GET" action="{{ request()->url() }}">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <!-- Status Filter -->
                                    <div>
                                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option value="">All Status</option>
                                            <option value="Full" {{ ($filters['status'] ?? '') === 'Full' ? 'selected' : '' }}>Full</option>
                                            <option value="In Stock" {{ ($filters['status'] ?? '') === 'In Stock' ? 'selected' : '' }}>In Stock</option>
                                            <option value="Low Stock" {{ ($filters['status'] ?? '') === 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                                            <option value="Out of Stock" {{ ($filters['status'] ?? '') === 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                                            <option value="Returned" {{ ($filters['status'] ?? '') === 'Returned' ? 'selected' : '' }}>Returned</option>
                                        </select>
                                    </div>

                                    <!-- Medicine Name Search -->
                                    <div>
                                        <label for="medicine_name" class="block mb-2 text-sm font-medium text-gray-900">Medicine Name</label>
                                        <input type="text" id="medicine_name" name="medicine_name" value="{{ $filters['medicine_name'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Search medicine name...">
                                    </div>

                                    <!-- Stock Number Search -->
                                    <div>
                                        <label for="stock_number" class="block mb-2 text-sm font-medium text-gray-900">Stock Number</label>
                                        <input type="text" id="stock_number" name="stock_number" value="{{ $filters['stock_number'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Search stock number...">
                                    </div>

                                    <!-- MOR Filter -->
                                    <div>
                                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">Memorandum Receipt (MOR)</label>
                                        <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option value="">All Users</option>
                                            @if(isset($users))
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Date Received Range -->
                                    <div>
                                        <label for="date_received_from" class="block mb-2 text-sm font-medium text-gray-900">Date Received From</label>
                                        <input type="date" id="date_received_from" name="date_received_from" value="{{ $filters['date_received_from'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>

                                    <div>
                                        <label for="date_received_to" class="block mb-2 text-sm font-medium text-gray-900">Date Received To</label>
                                        <input type="date" id="date_received_to" name="date_received_to" value="{{ $filters['date_received_to'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>

                                    <!-- Expiration Date Range -->
                                    <div>
                                        <label for="expiration_from" class="block mb-2 text-sm font-medium text-gray-900">Expiration From</label>
                                        <input type="date" id="expiration_from" name="expiration_from" value="{{ $filters['expiration_from'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>

                                    <div>
                                        <label for="expiration_to" class="block mb-2 text-sm font-medium text-gray-900">Expiration To</label>
                                        <input type="date" id="expiration_to" name="expiration_to" value="{{ $filters['expiration_to'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex justify-center items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="button" 
                                onclick="console.log('Apply clicked'); document.getElementById('filter-form').submit();" 
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Apply Filters
                            </button>
                            <button type="button" 
                                onclick="console.log('Clear clicked'); var form = document.getElementById('filter-form'); var inputs = form.querySelectorAll('input, select'); inputs.forEach(input => { if (input.tagName === 'SELECT') { input.selectedIndex = 0; } else { input.value = ''; } });" 
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add Form --}}
            @yield('inventory-add')

            {{-- Display Errors --}}
            @if ($errors->has('password'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ $errors->first('password') }}
                </div>
            @endif

            {{-- Table --}}
            @yield('inventory-table')

        </div>

        {{-- Message Modal --}}
        @if (session('status') || session('success') || session('error') || session('action'))
            <div id="message-modal" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 backdrop-blur-sm">
                <div class="w-full max-w-md p-6 transition-all duration-300 ease-out transform bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium
                            @if (session('action') == 'add') text-green-600
                            @elseif (session('action') == 'return') text-blue-600
                            @elseif (session('action') == 'edit') text-yellow-600
                            @elseif (session('action') == 'delete') text-red-600
                            @elseif (session('success')) text-green-600
                            @elseif (session('error')) text-red-600
                            @else text-gray-700 @endif">
                            @if (session('action') == 'add')
                                Added Successfully
                            @elseif (session('action') == 'return')
                                Returned Successfully
                            @elseif (session('action') == 'edit')
                                Updated Successfully
                            @elseif (session('action') == 'delete')
                                Deleted Successfully
                            @elseif (session('success'))
                                Success
                            @elseif (session('error'))
                                Error
                            @else
                                Notification
                            @endif
                        </h3>
                        <button onclick="closeModal()" class="text-gray-500 transition-colors hover:text-gray-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4">
                        <div class="p-3 rounded-md border-l-4 
                            @if (session('action') == 'add') bg-green-50 border-green-400
                            @elseif (session('action') == 'return') bg-blue-50 border-blue-400
                            @elseif (session('action') == 'edit') bg-yellow-50 border-yellow-400
                            @elseif (session('action') == 'delete') bg-red-50 border-red-400
                            @elseif (session('success')) bg-green-50 border-green-400
                            @elseif (session('error')) bg-red-50 border-red-400
                            @else bg-gray-50 border-gray-400 @endif">
                            <p class="text-gray-800">
                                @if (session('action'))
                                    @php
                                        $message = session('message') ?? 'Operation completed successfully.';
                                        $messageColor = session('action') == 'add' ? 'text-green-600' : 
                                                       (session('action') == 'return' ? 'text-blue-600' : 
                                                       (session('action') == 'edit' ? 'text-yellow-600' : 
                                                       (session('action') == 'delete' ? 'text-red-600' : 'text-gray-800')));
                                        
                                        // Check if message contains single quotes that might wrap a medicine name
                                        if (preg_match("/\'(.*?)\'/", $message, $matches)) {
                                            $medicineName = $matches[1];
                                            $messageParts = explode("'{$medicineName}'", $message);
                                            echo $messageParts[0] . "<span class='{$messageColor} font-medium'>'{$medicineName}'</span>" . $messageParts[1];
                                        } else {
                                            echo $message;
                                        }
                                    @endphp
                                @elseif (session('success'))
                                    {{ session('success') }}
                                @elseif (session('error'))
                                    {{ session('error') }}
                                @else
                                    {{ session('status') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button onclick="closeModal()" class="px-4 py-2 text-white rounded transition-all duration-200 hover:shadow-md
                            @if (session('action') == 'add') bg-green-500 hover:bg-green-600 
                            @elseif (session('action') == 'return') bg-blue-500 hover:bg-blue-600
                            @elseif (session('action') == 'edit') bg-yellow-500 hover:bg-yellow-600
                            @elseif (session('action') == 'delete') bg-red-500 hover:bg-red-600
                            @elseif (session('success')) bg-green-500 hover:bg-green-600
                            @elseif (session('error')) bg-red-500 hover:bg-red-600
                            @else bg-blue-500 hover:bg-blue-600 @endif">
                            Close
                        </button>
                    </div>
                </div>
            </div>

            <style>
                #message-modal {
                    animation: modalFadeIn 0.3s ease-out forwards;
                }
                #message-modal > div {
                    animation: modalContentIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
                }
                
                @keyframes modalFadeIn {
                    from {
                        opacity: 0;
                        backdrop-filter: blur(0);
                    }
                    to {
                        opacity: 1;
                        backdrop-filter: blur(4px);
                    }
                }
                
                @keyframes modalContentIn {
                    from {
                        opacity: 0;
                        transform: scale(0.9) translateY(-20px);
                    }
                    to {
                        opacity: 1;
                        transform: scale(1) translateY(0);
                    }
                }
                
                @keyframes modalFadeOut {
                    from {
                        opacity: 1;
                        backdrop-filter: blur(4px);
                    }
                    to {
                        opacity: 0;
                        backdrop-filter: blur(0);
                    }
                }
                
                @keyframes modalContentOut {
                    from {
                        opacity: 1;
                        transform: scale(1);
                    }
                    to {
                        opacity: 0;
                        transform: scale(0.95) translateY(10px);
                    }
                }
                
                .modal-closing {
                    animation: modalFadeOut 0.25s ease-in forwards !important;
                }
                
                .modal-content-closing {
                    animation: modalContentOut 0.2s ease-in forwards !important;
                }
            </style>

            <script>
                // Simple direct event handlers
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOM loaded - setting up filter handlers');
                    
                    // Get form and buttons
                    const filterForm = document.getElementById('filter-form');
                    
                    console.log('Form found:', !!filterForm);
                    
                    // Apply filters function
                    function handleApplyFilters() {
                        console.log('Apply filters triggered');
                        if (filterForm) {
                            console.log('Submitting form...');
                            filterForm.submit();
                        } else {
                            console.error('Form not found!');
                        }
                    }
                    
                    // Clear filters function
                    function handleClearFilters() {
                        console.log('Clear filters triggered');
                        if (filterForm) {
                            const inputs = filterForm.querySelectorAll('input, select');
                            inputs.forEach(input => {
                                if (input.tagName === 'SELECT') {
                                    input.selectedIndex = 0;
                                } else {
                                    input.value = '';
                                }
                            });
                            console.log('Filters cleared');
                        }
                    }
                    
                    // Clear and submit function
                    function handleClearAndSubmit() {
                        console.log('Clear and submit triggered');
                        handleClearFilters();
                        setTimeout(() => {
                            handleApplyFilters();
                        }, 100);
                    }
                    
                    // Message modal close function
                    window.closeModal = function() {
                        const modal = document.getElementById('message-modal');
                        if (modal) {
                            const modalContent = modal.querySelector('div');
                            
                            // Apply closing animations with classes
                            modal.classList.add('modal-closing');
                            modalContent.classList.add('modal-content-closing');
                            
                            // Remove the modal after animation completes
                            setTimeout(() => {
                                modal.style.display = 'none';
                            }, 300);
                        }
                    };
                    
                    // Initialize message modal if exists
                    const messageModal = document.getElementById('message-modal');
                    if (messageModal) {
                        messageModal.style.display = 'flex';
                    }
                });

                // Auto close message modal after 5 seconds
                setTimeout(() => {
                    if (document.getElementById('message-modal')) {
                        closeModal();
                    }
                }, 5000);
            </script>
        @endif
    </div>
@endsection

