@php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$defaultImage =
    'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2NjYyI+PHBhdGggZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MxLjY2IDAgMyAxLjM0IDMgM3MtMS4zNCAzLTMgMy0zLTEuMzQtMy0zIDEuMzQtMyAzLTN6bTAgMTQuMmMtMi41IDAtNC43MS0xLjI4LTYtMy4yMi4wMy0xLjk5IDQtMy4wOCA2LTMuMDggMS45OSAwIDUuOTcgMS4wOSA2IDMuMDgtMS4yOSAxLjk0LTMuNSAzLjIyLTYgMy4yMnoiLz48L3N2Zz4=';
$profileImage = $user && $user->profile_image ? asset('uploads/users/' . $user->profile_image) : $defaultImage;
@endphp

<!-- Add this in your <head> section -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--======== START NAVBAR =================-->
<nav
    class="container mx-auto fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-white border-b border-gray-200 h-14">
    <div class="flex flex-wrap items-center justify-between w-full">
        <div class="flex items-center justify-start">
            {{-- <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button> --}}
            {{-- to hide this navbar to profile page --}}
            {{-- @if (Route::currentRouteName() != 'profile.accountSettings' && Route::currentRouteName() != 'profile.helpAndSupport')
                <div class="flex items-center justify-center w-64 bg-[#560012] m-0 px-4 py-2.5"> --}}
            {{-- add dashboard route here --}}
            {{-- <a href="#" class="flex items-center justify-between mr-4">
                        <img src="{{ asset('images/puplogo.png') }}" class="h-8 mr-3" alt="Logo" />
                        <span class="self-center text-2xl font-semibold text-white whitespace-nowrap">PRMS</span>
                    </a>
                </div>
            @endif --}}

            <div class="flex items-center space-x-2 py-2">
                <!-- Logo -->
                <a class="flex-none inline-block text-xl font-semibold rounded-xl focus:outline-hidden focus:opacity-80"
                    href="#" aria-label="PRMS">
                    <div class="flex items-center justify-start w-full">
                        <!--PRMS logo-->
                        <img src="{{ asset('images/prms-logo 2.jpg') }}" alt="logo" class="w-10 mr-1 rounded-full">
                        <span class="text-2xl font-bold text-red-900 hidden md:block ml-1">PRMS</span>
                    </div>
                </a>
                <!-- End Logo -->
                @if (auth()->user() && auth()->user()->role == 'standard')
                    <div>
                        <a href="{{ route('dashboard') }}"
                            class="font-medium px-2 hover:underline text-base hover:text-blue-500">Dashboard</a>
                    </div>
                @else
                    <div>
                        <a href="{{ route('Superadmin_dashboard') }}"
                            class="font-medium px-2 hover:underline text-base hover:text-blue-500">Dashboard</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="relative flex items-center lg:order-2 space-x-1">
            <!-- Notifications -->
            <div class="relative">
                <!-- Notification Button -->
                <button type="button" id="notification-button"
                    class="p-2 px-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300">
                    <span class="sr-only">View notifications</span>
                    <!-- Bell icon -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                    @if (
    $notifications->filter(function ($notification) {
        return $notification->users->first() && is_null($notification->users->first()->pivot->viewed_at);
    })->count() > 0
)
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Custom Notification Dropdown -->
                <div id="notification-dropdown"
                    class="fixed z-50 hidden overflow-hidden bg-white rounded-lg shadow-lg w-96 max-w-[95vw]"
                    style="top: 4rem; right: 1rem;">
                    <!-- Header -->
                    <div class="sticky top-0 z-10 px-4 py-3 text-gray-700 bg-red-800 border-b border-gray-400">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-white">Notifications</h3>
                            @if ($notifications->count() > 0)
                                <span class="px-2 py-1 text-xs font-semibold text-black bg-white rounded-full">
                                    {{ $notifications->count() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Notification List -->
                    <div class="overflow-y-auto divide-y divide-gray-100"
                        style="max-height: min(calc(100vh - 12rem), 500px)">
                        @if ($notifications->count() > 0)
                            @foreach ($notifications as $notification)
                                <div class="notification-item p-4 {{ $notification->users->first() && is_null($notification->users->first()->pivot->viewed_at) ? 'bg-blue-50' : 'bg-white' }}"
                                    data-id="{{ $notification->id }}">
                                    <div class="flex">
                                        <!-- Notification Icon -->
                                        <div class="flex-shrink-0">
                                            <div
                                                class="flex items-center justify-center w-11 h-11 rounded-full
                                @if ($notification->type === 'warning') bg-yellow-300 text-yellow-900
                                @elseif($notification->type === 'danger') bg-red-300 text-red-900
                                @elseif($notification->type === 'deleted') bg-gray-300 text-gray-900
                                @else bg-blue-100 text-blue-600 @endif">
                                                @if ($notification->type === 'warning')
                                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @elseif($notification->type === 'danger')
                                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="20"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="20"></line>
                                                    </svg>
                                                @elseif($notification->type === 'deleted')
                                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Notification Content -->
                                        <div class="flex-1 ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                            <p class="mt-1 text-sm text-gray-500">{{ $notification->message }}</p>
                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center justify-center p-8">
                                <div class="text-center">
                                    <p class="mt-4 text-sm text-gray-500">No new notifications</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Profile --}}
            <div class="relative inline-block">
                <button type="button"
                    class="flex px-1 py-1 ml-1 text-sm text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ $profileImage }}" alt="user photo" />
                </button>

                <!-- Dropdown menu profile items -->
                <div id="profile-dropdown"
                    class="absolute z-50 hidden w-64 bg-white rounded-lg shadow-lg dropdown-menu-content top-full right-0 mt-2">
                    <a href="{{ route('user.profile') }}"
                        class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <svg class="inline w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                    <a href="{{ route('password.change') }}"
                        class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <svg class="inline w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                        <span>Change Password</span>
                    </a>
                    <a id="logout-button" class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <svg class="inline w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        <span>Log out</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    </div>
</nav>

<div id="logoutModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden overflow-auto bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-80">
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900">Logout</h3>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-600">Are you sure you want to log out?</p>
        </div>
        <div class="flex justify-end p-4">
            <button id="cancelButton"
                class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">Logout</button>
            </form>
        </div>
    </div>
</div>

<!-- Add confirmation modal -->
<div id="clearNotificationsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div class="relative w-full max-w-md bg-white rounded-lg shadow-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900">Clear All Notifications</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Are you sure you want to clear all notifications? This action cannot be undone.
                </p>

                <div class="flex justify-end mt-4 space-x-3">
                    <button id="cancelClearNotifications"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button id="confirmClearNotifications"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-center">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Success!</h3>
                <p class="mt-2 text-sm text-gray-500">All notifications have been cleared successfully.</p>

                <div class="mt-4">
                    <button id="successModalClose"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .dropdown-menu-content {
            right: auto;
            left: 0;
            top: 0;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // User menu dropdown functionality
        // (keeping this part as it's working fine)
        document.getElementById('user-menu-button').addEventListener('click', function() {
            document.querySelector('.dropdown-menu-content').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside the area of dropdown menu or its button
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown-menu-content');
            const button = document.getElementById('user-menu-button');
            if (!dropdown.classList.contains('hidden') && !dropdown.contains(event.target) && !button
                .contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Logout modal functionality
        // (keeping this part as it's working fine)
        const logoutModal = document.getElementById('logoutModal');
        const logoutButton = document.getElementById('logout-button');
        const cancelButton = document.getElementById('cancelButton');

        // Show the modal when the logout button is clicked
        logoutButton.addEventListener('click', function() {
            logoutModal.classList.remove('hidden');
        });

        // Hide the modal when the cancel button is clicked
        cancelButton.addEventListener('click', function() {
            logoutModal.classList.add('hidden');
        });

        // Hide the modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === logoutModal) {
                logoutModal.classList.add('hidden');
            }
        });

        // CUSTOM NOTIFICATION FUNCTIONALITY - Fixed implementation
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        let notificationViewTimer = null;

        // Get current user ID
        const currentUserId = {{ Auth::id() }};

        // Function to mark notifications as viewed
        function markNotificationsAsViewed(notificationIds) {
            if (!notificationIds) {
                notificationIds = Array.from(document.querySelectorAll('.notification-item.bg-blue-50'))
                    .map(el => el.dataset.id);
            }

            if (notificationIds.length === 0) return;

            fetch('/notifications/mark-as-viewed', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        notification_ids: notificationIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notificationIds.forEach(id => {
                            const notificationItem = document.querySelector(
                                `.notification-item[data-id="${id}"]`);
                            if (notificationItem) {
                                notificationItem.classList.remove('bg-blue-50');
                                notificationItem.classList.add('bg-white');
                            }
                        });

                        // Remove red dot if all notifications are viewed
                        if (document.querySelectorAll('.notification-item.bg-blue-50').length === 0) {
                            const indicator = document.querySelector('#notification-button .bg-red-500');
                            if (indicator) indicator.remove();
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Toggle notification dropdown - Fixed implementation
        notificationButton.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent any default behavior

            const isHidden = notificationDropdown.classList.contains('hidden');

            // Close any other open dropdowns first
            document.querySelectorAll('.dropdown-menu-content, #apps-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });

            console.log('Notification button clicked, dropdown is hidden:', isHidden);

            if (isHidden) {
                // Show dropdown
                notificationDropdown.classList.remove('hidden');
                console.log('Showing notification dropdown');

                // Clear any existing timer first
                if (notificationViewTimer) {
                    clearTimeout(notificationViewTimer);
                }

                // Set timer to mark as viewed after 5 seconds
                console.log('Setting timer to mark notifications as viewed in 5 seconds');
                notificationViewTimer = setTimeout(function() {
                    console.log('Timer triggered - marking notifications as viewed');
                    markNotificationsAsViewed();
                }, 5000);
            } else {
                // Hide dropdown
                notificationDropdown.classList.add('hidden');
                console.log('Hiding notification dropdown');

                // Clear timer
                if (notificationViewTimer) {
                    clearTimeout(notificationViewTimer);
                    notificationViewTimer = null;
                    console.log('Timer cleared');
                }
            }
        });

        // Close notification dropdown when clicking outside - Fixed implementation
        document.addEventListener('click', function(event) {
            // Only process if the dropdown is visible
            if (!notificationDropdown.classList.contains('hidden')) {
                // And if the click was outside both the dropdown and the button
                if (!notificationDropdown.contains(event.target) &&
                    !notificationButton.contains(event.target)) {

                    console.log(
                        'Clicked outside notification dropdown - marking as viewed and closing');

                    // Mark notifications as viewed
                    markNotificationsAsViewed();

                    // Clear timer
                    if (notificationViewTimer) {
                        clearTimeout(notificationViewTimer);
                        notificationViewTimer = null;
                        console.log('Timer cleared');
                    }

                    // Hide dropdown
                    notificationDropdown.classList.add('hidden');
                }
            }
        });

        // Handle "View all notifications" button click
        document.getElementById('view-all-notifications')?.addEventListener('click', function() {
            // Implementation for viewing all notifications
            // Could redirect to a notifications page or open a modal
            console.log('View all notifications clicked');
        });

        // Optional: Add click functionality to individual notifications
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                // Handle notification click (e.g., navigate to related content)
                console.log('Clicked notification:', this.dataset.id);

                // You could add navigation logic here
                // window.location.href = '/notifications/' + this.dataset.id;
            });
        });

        // Clear notifications modal functionality
        const clearNotificationsModal = document.getElementById('clearNotificationsModal');
        const clearNotificationsButton = document.getElementById('clear-notifications');
        const cancelClearNotificationsButton = document.getElementById('cancelClearNotifications');
        const confirmClearNotificationsButton = document.getElementById('confirmClearNotifications');

        if (clearNotificationsButton) {
            clearNotificationsButton.addEventListener('click', function() {
                clearNotificationsModal.classList.remove('hidden');
            });
        }

        if (cancelClearNotificationsButton) {
            cancelClearNotificationsButton.addEventListener('click', function() {
                clearNotificationsModal.classList.add('hidden');
            });
        }

        if (confirmClearNotificationsButton) {
            confirmClearNotificationsButton.addEventListener('click', function() {
                // Show loading state
                this.disabled = true;
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Clearing...
                `;

                fetch('/notifications/clear-all', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update UI
                            const notificationsList = document.querySelector(
                                '#notification-dropdown .overflow-y-auto');
                            const notificationCount = document.querySelector(
                                '#notification-button .bg-red-500');

                            // Clear notifications list
                            if (notificationsList) {
                                notificationsList.innerHTML = `
                                <div class="flex items-center justify-center p-8">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                        <p class="mt-4 text-sm text-gray-500">No new notifications</p>
                                    </div>
                                </div>
                            `;
                            }

                            // Remove notification count indicator
                            if (notificationCount) {
                                notificationCount.remove();
                            }

                            // Remove clear button
                            const clearButtonContainer = clearNotificationsButton.parentElement;
                            if (clearButtonContainer) {
                                clearButtonContainer.remove();
                            }

                            // Hide clear confirmation modal
                            clearNotificationsModal.classList.add('hidden');
                            notificationDropdown.classList.add('hidden');

                            // Show success modal
                            const successModal = document.getElementById('successModal');
                            successModal.classList.remove('hidden');

                            // Auto-hide success modal after 2 seconds
                            setTimeout(() => {
                                successModal.classList.add('hidden');
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error clearing notifications. Please try again.');
                    })
                    .finally(() => {
                        // Reset button state
                        this.disabled = false;
                        this.innerHTML = originalText;
                    });
            });
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === clearNotificationsModal) {
                clearNotificationsModal.classList.add('hidden');
            }
        });

        // Close success modal
        const successModalCloseButton = document.getElementById('successModalClose');
        if (successModalCloseButton) {
            successModalCloseButton.addEventListener('click', function() {
                const successModal = document.getElementById('successModal');
                successModal.classList.add('hidden');
            });
        }

        // Add success modal close button handler
        const successModalClose = document.getElementById('successModalClose');
        if (successModalClose) {
            successModalClose.addEventListener('click', function() {
                document.getElementById('successModal').classList.add('hidden');
            });
        }

        // Close success modal when clicking outside
        window.addEventListener('click', function(event) {
            const successModal = document.getElementById('successModal');
            if (event.target === successModal) {
                successModal.classList.add('hidden');
            }
        });
    });
</script>

<style>
    /* Improve scrollbar appearance */
    #notification-dropdown .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    #notification-dropdown .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #notification-dropdown .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 8px;
    }

    #notification-dropdown .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Better notification dropdown positioning */
    #notification-dropdown {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid rgba(229, 231, 235, 1) !important;
        position: absolute;
        top: calc(100% + 0.25rem) !important;
        margin-top: 0 !important;
        z-index: 50 !important;
    }

    @media (min-width: 640px) {
        #notification-dropdown {
            width: 24rem;
            /* w-96 */
            right: -9rem;
            /* Center it better under the button */
            left: auto !important;
            transform: translateX(0) !important;
        }
    }

    @media (max-width: 639px) {
        #notification-dropdown {
            width: 92vw;
            max-width: 92vw;
            position: fixed;
            top: 5rem !important;
            left: 50%;
            transform: translateX(-50%);
        }
    }

    /* Beautiful hover effect for notification items */
    .notification-item {
        transition: all 0.2s ease;
    }

    .notification-item:hover {
        transform: translateY(-1px);
    }
</style>
