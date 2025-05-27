@extends('layouts.profile')

@section('title', 'Settings')

@section('content')
    <div class="container mx-auto p-0 bg-white shadow-md rounded-lg">

        <div class="relative h-64 w-full">
            <img src="{{ asset('images/profile-header.png') }}" alt="profile header"
                class="object-cover w-full h-full rounded-t-lg">
            <div class="absolute top-48 left-20 flex items-center justify-center space-x-2">
                <div class="w-48 h-48 rounded-full bg-white p-3">
                    <img src="{{ asset('images/puplogo.png') }}" alt="Profile Picture"
                        class="rounded-full w-full h-full object-cover">
                </div>
                <h2 class="text-2xl font-semibold hidden md:block">Settings</h2>
            </div>
        </div>
        <div class="p-5 mt-20">
            <h2 class="text-2xl font-semibold block md:hidden mt-4">Settings</h2>

            <!--Settings Navigation Tab-->
            <div class="border-b border-gray-200 mt-4">
                <nav
                    class="-mb-px flex space-x-2 overflow-x-auto [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-thumb]:bg-gray-200 [&amp;::-webkit-scrollbar]:h-1.5">
                    <a href="{{ route('user.profile') }}"
                        class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out {{Route::is('user.profile') ? 'text-indigo-500 border-indigo-500 hover:text-indigo-600' : 'text-gray-500 border-transparent hover:text-indigo-500 hover:border-indigo-500'}} ">
                        <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 2.5C8.34315 2.5 7 3.84315 7 5.5C7 7.15685 8.34315 8.5 10 8.5C11.6569 8.5 13 7.15685 13 5.5C13 3.84315 11.6569 2.5 10 2.5ZM5.5 5.5C5.5 3.01472 7.51472 1 10 1C12.4853 1 14.5 3.01472 14.5 5.5C14.5 7.98528 12.4853 10 10 10C7.51472 10 5.5 7.98528 5.5 5.5ZM4 15C4 12.7909 5.79086 11 8 11H12C14.2091 11 16 12.7909 16 15C16 16.1046 15.1046 17 14 17H6C4.89543 17 4 16.1046 4 15ZM8 12.5C6.61929 12.5 5.5 13.6193 5.5 15C5.5 15.2761 5.72386 15.5 6 15.5H14C14.2761 15.5 14.5 15.2761 14.5 15C14.5 13.6193 13.3807 12.5 12 12.5H8Z"
                                fill="currentColor" />
                        </svg>
                        My Profile
                    </a>
                    <a href="{{ route('password.change') }}"
                        class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out bg-transparent {{Route::is('password.change') ? 'text-indigo-500 border-indigo-500 hover:text-indigo-600' : 'text-gray-500 border-transparent hover:text-indigo-500 hover:border-indigo-500'}}">
                        <svg class="size-5" width="20" height="20" viewBox="0 0 32 32" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21,2a8.9977,8.9977,0,0,0-8.6119,11.6118L2,24v6H8L18.3881,19.6118A9,9,0,1,0,21,2Zm0,16a7.0125,7.0125,0,0,1-2.0322-.3022L17.821,17.35l-.8472.8472-3.1811,3.1812L12.4141,20,11,21.4141l1.3787,1.3786-1.5859,1.586L9.4141,23,8,24.4141l1.3787,1.3786L7.1716,28H4V24.8284l9.8023-9.8023.8472-.8474-.3473-1.1467A7,7,0,1,1,21,18Z">
                            </path>
                            <circle cx="22" cy="10" r="2"></circle>
                        </svg>

                        Change Password
                    </a>
                </nav>
            </div>

            @yield('profile_content')

        </div>
    </div>
@endsection
