@extends('layouts.app-layoutadmin')

@section('title', 'User Management')

@section('content')
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <x-page-title value="User Management" class="mb-0" />
        <p class="text-sm text-gray-500 mb-7">A list of all registered users to this system.</p>

        <div class="h-full py-4 sm:py-5 mb-10 bg-white rounded-lg shadow-sm px-4 sm:px-7">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <input type="text" placeholder="Search for users..."
                    class="w-full sm:w-64 h-10 p-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                    id="user_search" autocomplete="off" />

                <!-- Add Button -->
                <button type="button" onclick="openAddModal()"
                class="inline-flex justify-center items-center whitespace-nowrap gap-2 px-6 py-2.5 text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md hover:shadow-lg active:shadow-sm transform focus:outline-none focus:ring-4 focus:ring-blue-300 active:translate-y-0">
                    <span class="font-medium">+ Add user</span>
                </button>
            </div>

            {{-- USERS TABLE --}}
            <div class="w-full overflow-x-auto rounded-lg my-7">
                <div class="min-w-full">
                    <table id="user_table" class="min-w-full rounded-lg shadow table-auto user_table">
                        <thead class="bg-gray-100 border-b-2 rounded-lg">
                            <tr>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">No.</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">First Name
                                </th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">Last Name
                                </th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">Email</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">Role</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">Is Activated
                                </th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max">Status
                                </th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-center min-w-max"></th>
                            </tr>
                        </thead>
                        <tbody class="text-xs sm:text-sm text-center" id="user_table_body">
                            @foreach ($users as $user)
                                <tr class="border-b user_row hover:bg-gray-50">
                                    <td class="px-5 py-3">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-5 py-3"> {{ ucfirst($user->first_name) }} </td>
                                    <td class="px-5 py-3">{{ ucfirst($user->last_name) }}</td>
                                    <td class="px-5 py-3">{{ $user->email }}</td>
                                    <td class="px-5 py-3">{{ ucfirst($user->role) }}</td>
                                    <td class="px-5 py-3">
                                        <span
                                            class="text-xs sm:text-sm {{ $user->is_activated ? 'text-green-500' : 'text-red-500' }} rounded-md px-2 py-1"
                                            style="background-color: {{ $user->is_activated ? '#DCF8F0' : '#FFDFDF' }};">
                                            {{ $user->is_activated ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-2 sm:px-5 py-2 sm:py-3">
                                        @php
                                            $statusColors = match ($user->status) {
                                                'active' => 'bg-green-100 text-green-500',
                                                'inactive' => 'bg-gray-100 text-gray-500',
                                                'suspended' => 'bg-orange-100 text-orange-800',
                                                'deactivated' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp

                                        <span class="text-xs sm:text-sm rounded-md px-2 py-1 font-medium {{ $statusColors }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="flex flex-col sm:flex-row items-center justify-end px-2 sm:px-5 py-2 sm:py-3 space-y-2 sm:space-y-0 sm:space-x-2">
                                        <button onclick="openEditModal(this)" data-id="{{ $user->id }}"
                                            data-firstname="{{ $user->first_name }}"
                                            data-lastname="{{ $user->last_name }}" data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}" data-status="{{ $user->status }}"
                                            class="w-full sm:w-auto px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('user.destroy') }}" method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            <input type="hidden" name="delete_user_id" id="id"
                                                value="{{ $user->id }}" name="id">
                                            <button type="button"
                                                onclick="confirmDelete('{{ $user->first_name }}', this.form)"
                                                class="w-full px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
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
                    <!-- No Users Found Message -->
                    <div id="no-users-message" class="hidden mt-4 text-center text-red-500">
                        No users found matching your search criteria.
                    </div>

                    <div class="mt-5">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==== Modals ====-->
    @include('SuperAdmin.users.create-form')
    @include('SuperAdmin.users.edit-form')

@endsection

@push('scripts')
    <script>
        const users = @json($users->items());

        function openAddModal() {
            let modal = document.getElementById("addFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
        }

        function closeAddModal() {
            let modal = document.getElementById("addFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); // Matches transition duration
        }

        function openEditModal(button) {

            const id = button.getAttribute("data-id");
            const lastName = button.getAttribute("data-lastname");
            const firstName = button.getAttribute("data-firstname");
            const email = button.getAttribute("data-email");
            const role = button.getAttribute("data-role");
            const status = button.getAttribute("data-status");

            // Set values to the form fields
            document.getElementById("user_id").value = id;
            document.getElementById("edit_first_name").value = firstName;
            document.getElementById("edit_last_name").value = lastName;
            document.getElementById("edit_email").value = email;
            document.getElementById("edit_role").value = role;
            document.getElementById("edit_status").value = status;

            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10); // Small delay to trigger animation
        }

        function closeEditModal() {
            // Get the modal element
            const modal = document.getElementById('editFormModal');
            const modalContent = modal.querySelector("div.relative");

            // Add a debug log to check if the function is being called
            console.log('Closing edit modal');

            try {
                // Apply closing animation
                modal.classList.add("opacity-0");
                modalContent.classList.remove("scale-100");
                modalContent.classList.add("scale-95");

                // Hide modal after animation completes
                setTimeout(() => {
                    modal.classList.add("hidden");

                    // clear form values (optional)
                    document.getElementById('user_id').value = "";
                    document.getElementById('edit_first_name').value = "";
                    document.getElementById('edit_last_name').value = "";
                    document.getElementById('edit_email').value = "";
                    document.getElementById('edit_role').value = "";
                    document.getElementById('edit_status').value = "";

                    console.log('Modal hidden');
                }, 300);
            } catch (error) {
                console.error('Error closing modal:', error);
                // Fallback: force hide the modal
                modal.style.display = 'none';
            }
        }


        function confirmDelete(user, form) {
            Swal.fire({
                title: "Warning!",
                html: "Are you sure you want to delete this account for <strong>" + user + "</strong>?",
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

        // search for user
        const userTableBody = document.getElementById('user_table_body');
        const searchInput = document.getElementById('user_search');

        function renderUsers(userList) {
            userTableBody.innerHTML = '';
            userList.forEach((user, index) => {
                const isActivated = user.is_activated;
                const statusColors = {
                    active: 'bg-green-100 text-green-500',
                    inactive: 'bg-gray-100 text-gray-500',
                    suspended: 'bg-orange-100 text-orange-800',
                    deactivated: 'bg-red-100 text-red-800',
                } [user.status] || 'bg-gray-100 text-gray-800';

                userTableBody.innerHTML += `
            <tr class="border-b user_row hover:bg-gray-50">
                <td class="px-5 py-3">${index + 1}</td>
                <td class="px-5 py-3">${capitalizeWords(user.first_name)}</td>
                <td class="px-5 py-3">${capitalizeWords(user.last_name)}</td>
                <td class="px-5 py-3">${user.email}</td>
                <td class="px-5 py-3">${capitalizeWords(user.role)}</td>
                <td class="px-5 py-3">
                    <span class="text-xs ${isActivated ? 'text-green-500' : 'text-red-500'} rounded-md px-2 py-1"
                          style="background-color: ${isActivated ? '#DCF8F0' : '#FFDFDF'};">
                        ${isActivated ? 'Yes' : 'No'}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs rounded-md px-2 py-1 font-medium ${statusColors}">
                        ${capitalizeWords(user.status)}
                    </span>
                </td>
                <td class="flex items-center justify-end px-5 py-3 space-x-2">
                    <button onclick="openEditModal(this)"
                        data-id="${user.id}"
                        data-firstname="${user.first_name}"
                        data-lastname="${user.last_name}"
                        data-email="${user.email}"
                        data-role="${user.role}"
                        data-status="${user.status}"
                        class="px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                        </svg>
                    </button>
                    <form action="{{ route('user.destroy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="delete_user_id" value="${user.id}">
                        <button type="button" onclick="confirmDelete('${user.first_name}', this.form)" class="px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
        `;
            });
        }


        function capitalizeWords(str) {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        }

        // Initial render
        renderUsers(users);

        // Filter users on keyup
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const noUsersMessage = document.getElementById('no-users-message');

            if (searchTerm === "") {
                renderUsers(users); // Show all users when input is cleared
                noUsersMessage.classList.add("hidden"); // Hide the error message
                return;
            }

            const filteredUsers = users.filter(user =>
                user.first_name.toLowerCase().includes(searchTerm) ||
                user.last_name.toLowerCase().includes(searchTerm) ||
                user.email.toLowerCase().includes(searchTerm) ||
                user.role.toLowerCase().includes(searchTerm) ||
                user.status.toLowerCase().includes(searchTerm)
            );

            if (filteredUsers.length > 0) {
                renderUsers(filteredUsers);
                noUsersMessage.classList.add("hidden");
            } else {
                userTableBody.innerHTML = "";
                noUsersMessage.classList.remove("hidden");
            }
        });
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
