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

    <x-inventory.table>
        <!-- HEADER  -->
        <x-inventory.table-head
            :headers="[
                'Date Received',
                'Stock #',
                'Medicine',
                'Unit',
                'Initial Quantity',
                'Consumed',
                'Balance',
                'Expiration Date',
                'MOR',
                'Actions'
            ]" 
        />

        <!-- CONTENT -->
        <x-inventory.table-body :data="$medicines" :users="$users">
            @foreach ($medicines as $medicine)
                <x-inventory.table-row>
                    <x-inventory.table-cell>{{ \Carbon\Carbon::parse($medicine->box->date_received)->format('Y-m-d') }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ $medicine->box->stock_number }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ $medicine->medicine_name }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ $medicine->unit }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ number_format($medicine->initial_quantity)}}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ number_format($medicine->consumed_quantity) }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ number_format($medicine->remaining_quantity) }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ \Carbon\Carbon::parse($medicine->expiration_date)->format("M' y") }}</x-inventory.table-cell>
                    <x-inventory.table-cell>{{ $medicine->box->user->first_name }}</x-inventory.table-cell>
                    <x-inventory.table-cell>
                        <div class="flex justify-center gap-2">
                            <!-- Return Button -->
                            <x-inventory.btn-return target="{{ 'return-'.$medicine->id }}"/>
                            <x-inventory.confirm-return 
                                target="{{'return-'.$medicine->id}}" 
                                action="{{ route('return_medicine', $medicine->id) }}" 
                            />
                            
                            <!-- Edit Button -->
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
                
                            <!-- Delete Button -->
                            <x-inventory.btn-delete target="{{'delete-'.$medicine->id}}" />
                            <x-inventory.confirm-deletion target="{{'delete-'.$medicine->id}}" action="{{ route('delete_medicine', $medicine->id) }}" />
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