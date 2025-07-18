@extends('layouts.inventory')

@section('inventory-add')
<x-inventory.modal target="create-inventory-medicines">
    <x-inventory.form method="POST" action="{{ route('add_medicine_store') }}" id="add-medicine-form" onsubmit="return validateDateSubmit('date_received', 'expiration_date')">
        
        <!-- Date Received -->
        <x-inventory.date
            label="Date Received" 
            name="date_received" 
            id="date_received"
            required
        />

        <!-- Expiration Date -->
        <x-inventory.date
            label="Expiration Date" 
            name="expiration_date" 
            id="expiration_date"
            required
        />

        <!-- Medicine Name -->
        <x-inventory.input
            label="Medicine Name" 
            name="medicine_name" 
            placeholder="Paracetamol 500mg"
            required
        />

        <!-- Stock Number -->
        <x-inventory.input
            label="Stock Number" 
            name="stock_number" 
            placeholder="STK-001"
            required
        />

        <!-- Unit of Measurement -->
        <x-inventory.input
            label="Unit of Measurement" 
            name="unit_of_measurement" 
            placeholder="Capsule"
            required
        />

        <!-- Initial Quantity -->
        <x-inventory.quantity
            label="Initial Quantity" 
            name="initial_quantity" 
            placeholder="100"
            min="0"
            step="1"
            required
        />

        <!-- User/Memorandum Receipt -->
        <x-inventory.select
            label="Memorandum Receipt"
            name="user_id"
            :options="$users->pluck('full_name', 'id')->toArray()"
            required
        />

        </x-inventory.form>
    </x-inventory.modal>


@endsection

@section('inventory-table')
    <!-- 
        ROW ACTIONS (PENDING)
        - Info (Mobile screen, View Toggle)
        - Delete (Soft)
        - Deduct (?)
    -->

    @php
        $hasActiveFilters = isset($filters) && !empty(array_filter($filters));
    @endphp

    @if($hasActiveFilters)
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="text-sm font-medium text-blue-800">Filters Applied</span>
                </div>
                <a href="{{ route('inventory-medicines') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Clear All Filters</a>
            </div>
        </div>
    @endif

    <x-inventory.table>
        <!-- HEADER  -->
        <x-inventory.table-head
            :headers="[
                'Date Received',
                'Stock #',
                'Medicine',
                'Unit',
                'Quantity',
                'Expiration Date',
                'MOR',
                'Status', // <-- Added Status column
                'Actions'
            ]"
            class="text-center align-middle"
        />

        <!-- CONTENT -->
        <x-inventory.table-body :data="$medicines" :users="$users">
            @foreach ($medicines as $medicine)
                <x-inventory.table-row class="text-center align-middle">
                    <x-inventory.table-cell class="align-middle">{{ \Carbon\Carbon::parse($medicine->box->date_received)->format('Y-m-d') }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">{{ $medicine->box->stock_number }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">{{ $medicine->medicine_name }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">{{ $medicine->unit }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">
                        {{ number_format($medicine->remaining_quantity) }}/{{ number_format($medicine->initial_quantity) }}
                    </x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">{{ \Carbon\Carbon::parse($medicine->expiration_date)->format("M' y") }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">{{ $medicine->box->user->first_name }}</x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">
                        @php
                            $isExpired = \Carbon\Carbon::parse($medicine->expiration_date)->isPast();
                            if ($medicine->box->isReturned) {
                                $status = 'Returned';
                                $statusColor = 'bg-gray-100 text-gray-800';
                            } elseif ($isExpired) {
                                $status = 'Expired';
                                $statusColor = 'bg-orange-100 text-orange-800';
                            } else {
                                $status = ucfirst($medicine->status);
                                $statusColor = match($status) {
                                    'Full' => 'bg-blue-100 text-blue-800',
                                    'In Stock' => 'bg-green-100 text-green-800',
                                    'Low Stock' => 'bg-yellow-100 text-yellow-800',
                                    'Out of Stock' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            }
                        @endphp
                        <span class="px-2 py-1 rounded font-semibold text-xs {{ $statusColor }}">
                            {{ $status }}
                        </span>
                    </x-inventory.table-cell>
                    <x-inventory.table-cell class="align-middle">
                        <div class="flex justify-center gap-2">
                            <!-- View Button (always visible) -->
                            <a href="{{ route('medicines.show', $medicine->id) }}"
                                class="inline-flex items-center gap-2 px-3 py-2 text-sm text-white transition-all duration-200 transform bg-green-500 rounded-lg shadow-md hover:bg-green-600 hover:shadow-lg active:shadow-sm active:bg-green-700 focus:outline-none focus:border-green-700 active:translate-y-0"
                                title="View Details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-9 9-9 9s-9-4-9-9a9 9 0 0118 0z" />
                                </svg>
                            </a>
                            @php
                                $isReturned = $medicine->box->isReturned;
                                $isExpired = \Carbon\Carbon::parse($medicine->expiration_date)->isPast();
                                $isOutOfStock = strtolower($medicine->status) === 'out of stock';
                            @endphp
                            @if(!$isReturned && !$isExpired && !$isOutOfStock)
                                <!-- Return Button -->
                                <span title="Return Medicine">
                                    <x-inventory.btn-return target="{{ 'return-'.$medicine->id }}"/>
                                </span>
                                <x-inventory.confirm-return 
                                    target="{{'return-'.$medicine->id}}" 
                                    action="{{ route('return_medicine', $medicine->id) }}" 
                                />
                                <!-- Edit Button -->
                                <span title="Edit Medicine">
                                    <x-inventory.btn-edit-modal heading="Edit a Record" target="{{ 'edit-'.$medicine->id }}" >  
                                        <x-inventory.form method="POST" action="{{ route('update_medicine', $medicine->id) }}" 
                                            id="edit-medicine-form-{{ $medicine->id }}"
                                            onsubmit="return validateDateSubmit('edit-date-received-{{ $medicine->id }}', 'edit-expiration-date-{{ $medicine->id }}')">
                                            @method('PUT')
                                            <!-- date_received -->
                                            <x-inventory.date
                                                label="Date Received" 
                                                name="date_received"    
                                                value="{{ old('date_received', \Carbon\Carbon::parse($medicine->box->date_received)->format('Y-m-d')) }}"
                                                id="edit-date-received-{{ $medicine->id }}"
                                                required
                                            />
                                            <!-- expiration_date -->
                                            <x-inventory.date
                                                label="Expiration Date" 
                                                name="expiration_date" 
                                                value="{{ old('expiration_date', \Carbon\Carbon::parse($medicine->expiration_date)->format('Y-m-d')) }}"
                                                id="edit-expiration-date-{{ $medicine->id }}"
                                                required
                                            />
                                            <!-- medicine_name -->
                                            <x-inventory.input
                                                label="Medicine Name" 
                                                name="medicine_name" 
                                                value="{{ old('medicine_name', $medicine->medicine_name) }}"
                                                placeholder="Paracetamol 500mg"
                                                required
                                            />
                                            <!-- stock_number -->
                                            <x-inventory.input
                                                label="Stock #" 
                                                name="stock_number" 
                                                value="{{ old('stock_number', $medicine->box->stock_number) }}"
                                                placeholder="##-###"
                                                required
                                            />
                                            <!-- unit_of_measurement-->
                                            <x-inventory.input
                                                label="Unit of Measurement" 
                                                name="unit_of_measurement" 
                                                value="{{ old('unit_of_measurement', $medicine->unit) }}"
                                                placeholder="Capsule"
                                                required
                                            />
                                            <!-- initial_quantity -->
                                            <x-inventory.quantity
                                                label="Initial Quantity"
                                                name="initial_quantity"
                                                value="{{ old('initial_quantity', $medicine->initial_quantity) }}"
                                                :min="$medicine->consumed_quantity"
                                                placeholder="100"
                                                required
                                            />
                                            <!-- user_id / memorandum_receipt -->
                                            <x-inventory.select
                                                label="MOR" 
                                                name="user_id" 
                                                :selected="$medicine->box->user_id"
                                                :options="$users->pluck('full_name', 'id')->toArray()"
                                                required
                                            />
                                        </x-inventory.form>
                                    </x-inventory.btn-edit-modal> 
                                </span>
                                <!-- Delete Button -->
                                <span title="Delete Medicine">
                                    <x-inventory.btn-delete target="{{'delete-'.$medicine->id}}" />
                                </span>
                                <x-inventory.confirm-deletion target="{{'delete-'.$medicine->id}}" action="{{ route('delete_medicine', $medicine->id) }}" />
                            @endif
                        </div>
                    </x-inventory.table-cell>
                </x-inventory.table-row>
            @endforeach
        </x-inventory.table-body>
    </x-inventory.table>

    {{ $medicines->links() }}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all medicine forms
    const forms = document.querySelectorAll('form[id$="medicine-form"], form[id^="edit-medicine-form"]');
    
    forms.forEach(form => {
        const formId = form.id;
        const dateReceived = form.querySelector('[name="date_received"]');
        const expirationDate = form.querySelector('[name="expiration_date"]');
        
        if (dateReceived && expirationDate) {
            // Initially disable expiration date if date_received is empty
            if (!dateReceived.value) {
                expirationDate.disabled = true;
            } else {
                // Set min date to date_received value
                expirationDate.min = dateReceived.value;
            }
            
            // Helper message
            const helperText = document.createElement('p');
            helperText.className = 'text-xs text-gray-500 mt-1';
            helperText.textContent = dateReceived.value ? 'Must be after date received' : 'Please select date received first';
            expirationDate.parentNode.appendChild(helperText);
            
            // When date_received changes, update expiration_date constraints
            dateReceived.addEventListener('change', function() {
                if (this.value) {
                    // Enable expiration date field
                    expirationDate.disabled = false;
                    
                    // Set minimum date to date received
                    expirationDate.min = this.value;
                    
                    // Update helper text
                    helperText.textContent = 'Must be after date received';
                    
                    // Clear expiration date if it's now invalid
                    if (expirationDate.value && expirationDate.value <= this.value) {
                        expirationDate.value = '';
                    }
                } else {
                    // If date received is cleared, disable expiration date
                    expirationDate.disabled = true;
                    expirationDate.value = '';
                    helperText.textContent = 'Please select date received first';
                }
            });
            
            // Only allow form submission if expiration date is after date received
            form.addEventListener('submit', function(e) {
                if (dateReceived.value && expirationDate.value) {
                    if (expirationDate.value <= dateReceived.value) {
                        e.preventDefault();
                        alert('Expiration date must be after date received');
                    }
                }
            });
        }
    });
});
</script>
@endpush