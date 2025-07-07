@extends('layouts.app-layoutadmin')

@section('title', 'Super Admin | Dashboard')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full">
                <div class="w-full">
                    <x-page-title value="Dashboard" />
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Rectangle 1 -->
                    <div class="flex items-center justify-center px-4 py-10 space-x-3 bg-white rounded-lg shadow min-w-fit">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center text-blue-500 rounded-full bg-blue-50 w-14 h-14">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-4xl font-semibold">{{ $total_users }}</p>
                            <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Users</h2>
                        </div>
                    </div>

                    <!-- Rectangle 2 -->
                    <div class="flex items-center justify-center px-4 py-10 space-x-3 bg-white rounded-lg shadow min-w-fit">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center text-green-500 rounded-full bg-green-50 w-14 h-14">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill"
                                    viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-4xl font-semibold">{{ $total_active_users }}</p>
                            <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Active Users</h2>
                        </div>
                    </div>

                    <!-- Rectangle 3 -->
                    <div class="flex items-center justify-center px-4 py-10 space-x-3 bg-white rounded-lg shadow min-w-fit">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center text-red-500 rounded-full bg-red-50 w-14 h-14">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill"
                                    viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-4xl font-semibold">{{ $total_inactive_users }}</p>
                            <h2 class="mt-1 text-base text-gray-600 font-regular text-wrap">Total Inactive Users</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
