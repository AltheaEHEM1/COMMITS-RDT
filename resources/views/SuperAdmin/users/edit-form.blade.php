<div id="editFormModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 bg-black/50">
    <!-- Modal content -->
    <div
        class="relative w-full h-full max-w-2xl p-4 transition-transform duration-300 ease-out transform scale-95 bg-white rounded-lg shadow md:h-auto sm:p-5">
        <!-- Modal header -->
        <div class="flex items-center justify-between pb-4 mb-4 rounded-t sm:mb-5">
            <h3 class="text-lg font-semibold text-gray-900">
                Edit User Details
            </h3>
            <button type="button" onclick="closeEditModal()"
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
        <form action="{{ route('user.update') }}" method="POST" class="max-h-[80vh] overflow-y-auto ">
            @csrf
            <div class="grid gap-4 px-2 mb-4 sm:grid-cols-2">
                <input type="hidden" value="" name="id" id="user_id"/>

                <!-- First Name Field -->
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="edit_first_name"
                        class=" bg-gray-50 border border-gray-300 cursor-not-allowed text-gray-500 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter first name" disabled>
                </div>

                <!-- last Name Field -->
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="edit_last_name"
                        class=" bg-gray-50 border border-gray-300 cursor-not-allowed text-gray-500 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter last name" disabled>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email
                        <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="edit_email"
                        class=" bg-gray-50 border border-gray-300 cursor-not-allowed text-gray-500 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Enter email" disabled>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role
                        <span class="text-red-500">*</span></label>
                    <select name="role" id="edit_role"
                        class=" bg-gray-50 border border-gray-300 text-gray-500 cursor-not-allowed text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5" disabled>
                        <option value="" selected >Select a role</option>
                        <option value="standard">Standard User</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status
                        <span class="text-red-500">*</span></label>
                    <select name="status" id="edit_status"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5" required>
                        <option value="" selected >Select a status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                        <option value="deactivated">Deactivated</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end w-full gap-3 mt-6">
                <button onclick="closeEditModal()" type="button"
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

<script>
function closeEditModal() {
    const modal = document.getElementById('editFormModal');
    
    if (!modal) {
        console.error('Modal element not found');
        return;
    }
    
    // Add a debug log to check if the function is being called
    console.log('Closing edit modal');
    
    try {
        // Apply closing animation
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        const modalContent = modal.querySelector('div');
        if (modalContent) {
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }
        
        // Hide modal after animation completes
        setTimeout(() => {
            modal.classList.add('hidden');
            console.log('Modal hidden');
        }, 300);
    } catch (error) {
        console.error('Error closing modal:', error);
        // Fallback: force hide the modal
        modal.style.display = 'none';
    }
}

// Function to open the edit modal with pre-filled data
function openEditModal(button) {
    // Get user data from button data attributes
    const userId = button.getAttribute('data-id');
    const firstName = button.getAttribute('data-firstname');
    const lastName = button.getAttribute('data-lastname');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');
    const status = button.getAttribute('data-status');
    
    // Set values in the form
    document.getElementById('user_id').value = userId;
    document.getElementById('edit_first_name').value = firstName;
    document.getElementById('edit_last_name').value = lastName;
    document.getElementById('edit_email').value = email;
    
    // Set selected values for dropdowns
    const roleSelect = document.getElementById('edit_role');
    for (let i = 0; i < roleSelect.options.length; i++) {
        if (roleSelect.options[i].value === role) {
            roleSelect.selectedIndex = i;
            break;
        }
    }
    
    const statusSelect = document.getElementById('edit_status');
    for (let i = 0; i < statusSelect.options.length; i++) {
        if (statusSelect.options[i].value === status) {
            statusSelect.selectedIndex = i;
            break;
        }
    }
    
    // Show the modal with animation
    const modal = document.getElementById('editFormModal');
    modal.classList.remove('hidden');
    
    // Trigger reflow to ensure transition works
    void modal.offsetWidth;
    
    // Apply opening animation
    modal.classList.remove('opacity-0');
    modal.classList.add('opacity-100');
    
    const modalContent = modal.querySelector('div');
    modalContent.classList.remove('scale-95');
    modalContent.classList.add('scale-100');
}
</script>