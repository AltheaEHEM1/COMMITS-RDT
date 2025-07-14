@extends('layouts.app-layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('inventory-medicines') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $medicine->medicine_name }}</h1>
                        <p class="text-gray-500 text-sm">Stock #{{ $medicine->box->stock_number }}</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                @php
                    if ($medicine->box->isReturned) {
                        $status = 'Returned';
                        $statusColor = 'bg-gray-500 text-white';
                    } else {
                        $status = ucfirst($medicine->status);
                        $statusColor = match($status) {
                            'Full' => 'bg-blue-500 text-white',
                            'In Stock' => 'bg-green-500 text-white',
                            'Low Stock' => 'bg-yellow-500 text-white',
                            'Out of Stock' => 'bg-red-500 text-white',
                            default => 'bg-gray-500 text-white',
                        };
                    }
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                    {{ $status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2">
                <!-- Medicine Details -->
                <div class="bg-white rounded-lg shadow p-6 h-full">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Medicine Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Medicine Name</label>
                                <p class="mt-1 text-gray-900">{{ $medicine->medicine_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Unit</label>
                                <p class="mt-1 text-gray-900">{{ $medicine->unit }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date Received</label>
                                <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($medicine->box->date_received)->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Expiration Date</label>
                                <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($medicine->expiration_date)->format('M j, Y') }}</p>
                            </div>
                        </div>

                        <!-- Quantity Info -->
                        <div class="space-y-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <label class="block text-sm font-medium text-blue-700">Initial Quantity</label>
                                <p class="text-xl font-bold text-blue-900">{{ number_format($medicine->initial_quantity) }} {{ $medicine->unit }}</p>
                            </div>
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <label class="block text-sm font-medium text-orange-700">Consumed</label>
                                <p class="text-xl font-bold text-orange-900">{{ number_format($medicine->consumed_quantity) }} {{ $medicine->unit }}</p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <label class="block text-sm font-medium text-green-700">Remaining</label>
                                <p class="text-xl font-bold text-green-900">{{ number_format($medicine->remaining_quantity) }} {{ $medicine->unit }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- MOR Info -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-600">Received by</label>
                        <p class="mt-1 text-gray-900">{{ $medicine->box->user->full_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 h-full">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h2>
                    
                    <!-- Usage Progress Bar -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-semibold text-gray-700">Usage Progress</span>
                            <span class="text-lg font-bold text-blue-600">{{ $stats['usage_percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $stats['usage_percentage'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 text-center">
                            <span class="font-semibold">{{ number_format($medicine->consumed_quantity) }}</span> of 
                            <span class="font-semibold">{{ number_format($medicine->initial_quantity) }}</span> {{ $medicine->unit }} used
                        </p>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Prescriptions</span>
                            <span class="font-bold text-blue-600">{{ $stats['total_prescriptions'] }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Patients served</span>
                            <span class="font-bold text-green-600">{{ $stats['total_patients_served'] }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg border border-orange-200">
                            <span class="text-sm font-medium text-gray-700">Monthly usage</span>
                            <span class="font-bold text-orange-600">{{ $stats['monthly_usage'] }} {{ $medicine->unit }}</span>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    @if($activityLogs->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-md font-semibold text-gray-900 mb-4">Recent Activity</h3>
                        
                        <div class="space-y-3">
                            @foreach($activityLogs->take(3) as $log)
                            <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($log->description) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $log->created_at->format('M j, g:i A') }}
                                        @if($log->causer)
                                            by {{ $log->causer->full_name ?? $log->causer->name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Prescription History (Full Width Below) -->
        @if($medicine->relationLoaded('prescriptionMedicines') && $medicine->prescriptionMedicines->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Prescription History</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prescribed</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($medicine->prescriptionMedicines->take(5) as $prescriptionMedicine)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $prescriptionMedicine->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                @if($prescriptionMedicine->patient)
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium text-xs mr-2">
                                            {{ substr($prescriptionMedicine->patient->firstName, 0, 1) }}
                                        </div>
                                        {{ $prescriptionMedicine->patient->fullname }}
                                    </div>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                    {{ $prescriptionMedicine->quantity ?? 'N/A' }} {{ $medicine->unit }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $prescriptionMedicine->updated_at->format('M j, g:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($medicine->prescriptionMedicines->count() > 5)
            <p class="mt-3 text-sm text-gray-500 text-center">
                Showing 5 of {{ $medicine->prescriptionMedicines->count() }} prescriptions
            </p>
            @endif
        </div>
        @elseif($medicine->relationLoaded('prescriptionMedicines'))
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Prescription History</h2>
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">No prescription history available</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection