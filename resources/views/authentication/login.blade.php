@extends('layouts.guest-layout')

@section('guest_content')
    <div class="space-y-6">
        <div class="text-center">
            <!-- Placeholder for logo -->
            <div
                class="mx-auto h-14 w-14 bg-gradient-to-r rounded-full flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/prms-logo 2.jpg') }}" alt="Logo" class="h-full w-full object-cover">
            </div>

            <h1 class="mt-4 text-xl font-semibold text-gray-900">
                PRMS
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Log in to access patient records
            </p>
        </div>

        <form class="space-y-4 md:space-y-6" id="form" action="{{ route('login') }}" method="post">
            @csrf
            {{-- Email --}}
            <div class="mt-8 input-control">
                <div class="inline-flex items-center space-x-1">
                    <x-input-label for="email" value="Email" />
                    <span class="text-red-500">*</span>
                </div>
                <x-input-textfield id="email" name="email" class="" placeholder="Enter your email" />
                <div class="mt-2 ml-1 text-xs text-red-500 error"></div> <!-- Error div for email -->

                {{-- Error message for invalid credentials --}}
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mt-2">
                <div class="inline-flex items-center space-x-1">
                    <x-input-label for="password" value="Password" />
                    <span class="text-red-500">*</span>
                </div>
                <div class="relative input-control">
                    <x-input-textfield id="password" type="password" name="password" placeholder="Enter your password" />
                    <span id="password-hidden"
                        class="absolute text-gray-600 transform -translate-y-1/2 cursor-pointer right-3 top-1/2">
                        <i class="text-sm fas fa-eye-slash"></i>
                    </span>
                    <span id="password-show"
                        class="absolute hidden text-gray-600 transform -translate-y-1/2 cursor-pointer right-3 top-1/2">
                        <i class="text-sm fas fa-eye"></i>
                    </span>
                </div>
                <div id="password-error" class="block mt-2 ml-1 text-xs text-red-500 w-80"></div>

                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Forgot Password --}}
            <div class="flex justify-end w-full mt-2">
                <a class="text-sm font-medium hover:text-blue-600 text-blue-600 hover:underline"
                    href="{{ route('password.request') }}">Forgot
                    password?</a>
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Continue</button>
        </form>
    </div>
@endsection
