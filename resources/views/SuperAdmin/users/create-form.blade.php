<div id="addFormModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <!-- Modal content -->
    <div
        class="relative w-full h-full max-w-2xl p-4 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <!-- Modal header -->
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Create New user
            </h3>
            <button type="button" onclick="closeAddModal()"
                class="inline-flex items-center p-2 ml-auto text-sm text-gray-400 bg-gray-200 rounded-full focus:ring-4 focus:outline-none focus:ring-gray-300 hover:bg-gray-300 hover:text-gray-900"
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
        <form id="createUserForm" method="POST" action="{{ route('user.store') }}" class="max-h-[80vh] overflow-y-auto" onsubmit="submitUserForm(event)">
            @csrf
            <div id="formErrors" class="hidden p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul class="pl-4 list-disc" id="errorList"></ul>
            </div>
            
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="pl-4 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="grid gap-4 px-2 mb-4 sm:grid-cols-2">

                <!-- First Name Field -->
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="first_name"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter first name" required="">
                </div>

                <!-- last Name Field -->
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter last name" required="">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email
                        <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter email" required="">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role
                        <span class="text-red-500">*</span></label>
                    <select name="role" id="role"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5" required="">
                        <option value="" selected >Select a role</option>
                        <option value="standard">Standard User</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end w-full gap-3 mt-6">
                <button onclick="closeAddModal()" type="button"
                    class="flex justify-center w-full px-4 py-3 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-300 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 sm:w-auto">
                    Close
                </button>
                <button type="submit"
                    class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-green-500 rounded-lg focus:ring-4 focus:outline-none focus:ring-green-300 hover:bg-green-600 bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function submitUserForm(event) {
    event.preventDefault();
    
    const form = document.getElementById('createUserForm');
    const formData = new FormData(form);
    const formErrors = document.getElementById('formErrors');
    const errorList = document.getElementById('errorList');
    
    // Clear previous errors
    errorList.innerHTML = '';
    formErrors.classList.add('hidden');

    // Add loading state to the submit button
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = `<svg class="w-4 h-4 mr-2 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg> Saving...`;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        if (data.success) {
            // Show success message
            Swal.fire({
                title: "Success!",
                text: data.message || "User created successfully!",
                icon: "success",
                confirmButtonColor: '#10B981'
            }).then((result) => {
                // Close the modal
                closeAddModal();
                
                // Refresh the user list or add the new user to the existing list
                if (typeof loadUsers === 'function') {
                    loadUsers(); // Refresh the user list if loadUsers function exists
                } else {
                    // Refresh the page as fallback
                    window.location.reload();
                }
            });
            
            // Reset the form
            form.reset();
        } else if (data.errors) {
            // Show validation errors
            formErrors.classList.remove('hidden');
            
            Object.keys(data.errors).forEach(key => {
                data.errors[key].forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
            });
        } else {
            // Show generic error
            Swal.fire({
                title: "Error!",
                text: data.message || "Something went wrong!",
                icon: "error"
            });
        }
    })
    .catch(error => {
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        console.error('Error:', error);
        Swal.fire({
            title: "Error!",
            text: "Something went wrong. Please try again.",
            icon: "error"
        });
    });
}

function closeAddModal() {
    const modal = document.getElementById('addFormModal');
    
    // Apply closing animation
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    
    const modalContent = modal.querySelector('div');
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    
    // Hide modal after animation completes
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
    
    // Reset form when modal is closed
    document.getElementById('createUserForm').reset();
    document.getElementById('formErrors').classList.add('hidden');
    document.getElementById('errorList').innerHTML = '';
}
</script>