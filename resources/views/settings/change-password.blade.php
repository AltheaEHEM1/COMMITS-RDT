@extends('settings.index')

@section('profile_content')
    <!--Change password-->
    <form id="change-password-form" action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid gap-6 mb-4 md:grid-cols-4 mt-4 px-3">
            <div>
                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Current Password <span
                        class="text-red-500">*</span></label>
                <input type="password" id="current_password" name="current_password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5"
                    placeholder="Type your current password"
                    @error('current_password') style="border-color: red" @enderror />
                <div id="current-password-error" class="block mt-2 ml-1 text-sm text-red-500 w-80"></div>
                @error('current_password')
                    <p class="text-sm text-red-500 text-start">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 mb-10 md:grid-cols-4 px-3">
            <!-- New Password -->
            <div>
                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">New Password <span
                        class="text-red-500">*</span></label>
                <div class="relative input-control">
                    <input type="password" id="new_password" name="new_password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5 pr-10"
                        placeholder="Type your new password" @error('new_password') style="border-color: red" @enderror />

                    <!-- Eye Slash Icon (Password Hidden) -->
                    <span id="new-password-hidden" class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                        <i class="text-sm fas fa-eye-slash text-gray-500"></i>
                    </span>

                    <!-- Eye Icon (Password Show) -->
                    <span id="new-password-show" class="absolute inset-y-0 right-3 hidden flex items-center cursor-pointer">
                        <i class="text-sm fas fa-eye text-gray-500"></i>
                    </span>
                </div>
                <p id="new-password-error" class="block mt-2 ml-1 text-sm text-red-500 text-wrap"></p>
                @error('new_password')
                    <p class="text-sm text-red-500 text-start">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password <span
                        class="text-red-500">*</span></label>
                <div class="relative input-control">
                    <input type="password" id="confirm_password" name="new_password_confirmation"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:outline-none focus:ring-blue-500 block w-full p-2.5 pr-10"
                        placeholder="Re-type your new password"
                        @error('new_password_confirmation') style="border-color: red" @enderror />

                    <!-- Eye Slash Icon (Password Hidden) -->
                    <span id="confirm-password-hidden" class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                        <i class="text-sm fas fa-eye-slash text-gray-500"></i>
                    </span>

                    <!-- Eye Icon (Password Show) -->
                    <span id="confirm-password-show"
                        class="absolute inset-y-0 right-3 hidden flex items-center cursor-pointer">
                        <i class="text-sm fas fa-eye text-gray-500"></i>
                    </span>
                </div>
                <div id="confirm-password-error" class="block mt-2 ml-1 text-sm text-red-500 w-80"></div>
                @error('new_password_confirmation')
                    <p class="text-sm text-red-500 text-start">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 mb-10 md:grid-cols-5 px-3">
            <button id="saveButton" type="submit"
                class="flex justify-center items-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-500 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 hover:bg-blue-600 shadow-theme-xs sm:w-auto">
                <span class="button-text">Save Changes</span>
                <svg class="hidden w-4 h-4 ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const form = document.getElementById("change-password-form");
        const currentPassword = document.getElementById("current_password");
        const newPassword = document.getElementById("new_password");
        const confirmPassword = document.getElementById("confirm_password");
        const button = document.getElementById("saveButton");
        const buttonText = button.querySelector(".button-text");
        const spinner = button.querySelector("svg");


        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const isValid = validateInputs();

            if (isValid) {
                button.disabled = true;
                buttonText.textContent = "Saving...";
                spinner.classList.remove("hidden");
                form.submit();
            }
        });

        function validateInputs() {
            let valid = true;

            if (validateCurrentPassword() === false) {
                valid = false;
            }

            if (validateNewPassword() === false) {
                valid = false;
            }

            if (validateConfirmPassword() === false) {
                valid = false;
            }

            return valid;

        }

        function validateCurrentPassword() {
            const currentPasswordValue = currentPassword.value;
            const currentPasswordError = document.getElementById("current-password-error");

            if (currentPasswordValue === "") {
                currentPasswordError.innerText = "This field is required";
                currentPassword.classList.remove("focus:ring-blue-500");
                currentPassword.classList.add("focus:ring-red-400");
                return false;
            } else {
                currentPasswordError.innerText = "";
                currentPassword.classList.add("focus:ring-blue-500");
                currentPassword.classList.remove("focus:ring-red-400");
                return true;
            }
        }

        function validateNewPassword() {
            const newPasswordValue = newPassword.value;
            const newPasswordError = document.getElementById("new-password-error");
            const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])\S{8,}$/;

            if (newPasswordValue === "") {
                newPasswordError.innerText = "This field is required";
                newPassword.classList.remove("focus:ring-blue-500");
                newPassword.classList.add("focus:ring-red-400");
                return false;
            } else if (!passwordRegex.test(newPasswordValue)) {
                newPasswordError.innerText =
                    "Password must be at least 8 characters, with an uppercase letter, lowercase letter, number, and special character";
                newPassword.classList.remove("focus:ring-blue-500");
                newPassword.classList.add("focus:ring-red-400");
                return false;
            } else {
                newPasswordError.innerText = "";
                newPassword.classList.add("focus:ring-blue-500");
                newPassword.classList.remove("focus:ring-red-400");
                return true;
            }
        }

        function validateConfirmPassword() {
            const newPasswordValue = newPassword.value;
            const confirmPasswordValue = confirmPassword.value;
            const confirmPasswordError = document.getElementById("confirm-password-error");

            if (confirmPasswordValue === "") {
                confirmPasswordError.innerText = "This field is required";
                confirmPassword.classList.remove("focus:ring-blue-500");
                confirmPassword.classList.add("focus:ring-red-400");
                return false;
            } else if (confirmPasswordValue != newPasswordValue) {
                confirmPasswordError.innerText = "Password don't match";
                confirmPassword.classList.remove("focus:ring-blue-500");
                confirmPassword.classList.add("focus:ring-red-400");
                return false;
            } else {
                confirmPasswordError.innerText = "";
                confirmPassword.classList.add("focus:ring-blue-500");
                confirmPassword.classList.remove("focus:ring-red-400");
                return true;
            }
        }

        // Add event listeners to trigger validation on input change
        currentPassword.addEventListener("input", () => validateCurrentPassword());
        newPassword.addEventListener("input", () => validateNewPassword());
        confirmPassword.addEventListener("input", () => validateConfirmPassword());

        // PASSWORD MASKING
        const newPasswordField = document.getElementById("new_password");
        const confirmPasswordField = document.getElementById("confirm_password");
        const newPasswordHidden = document.getElementById("new-password-hidden");
        const newPasswordShow = document.getElementById("new-password-show");
        const confirmPasswordHidden = document.getElementById("confirm-password-hidden");
        const confirmPasswordShow = document.getElementById("confirm-password-show");

        // NEW PASSWORD ICONS
        newPasswordHidden.addEventListener("click", () => {
            newPasswordField.type = newPasswordField.type === "password" ? "text" : "password";
            newPasswordHidden.classList.add("hidden");
            newPasswordShow.classList.remove("hidden");
        });

        newPasswordShow.addEventListener("click", () => {
            newPasswordField.type = newPasswordField.type === "text" ? "password" : "text";
            newPasswordShow.classList.add("hidden");
            newPasswordHidden.classList.remove("hidden");
        });

        // CONFIRM PASSWORDS ICON
        confirmPasswordHidden.addEventListener("click", () => {
            confirmPasswordField.type = confirmPasswordField.type === "password" ? "text" : "password";
            confirmPasswordHidden.classList.add("hidden");
            confirmPasswordShow.classList.remove("hidden");
        });

        confirmPasswordShow.addEventListener("click", () => {
            confirmPasswordField.type = confirmPasswordField.type === "text" ? "password" : "text";
            confirmPasswordShow.classList.add("hidden");
            confirmPasswordHidden.classList.remove("hidden");
        });
    </script>

    @if (session('success_change'))
        <script>
            Swal.fire({
                title: "Success!",
                text: `{!! session('success_change') !!}`,
                icon: "success"
            });
        </script>
    @endif

    @if (session('error_change'))
        <script>
            Swal.fire({
                title: "Error!",
                text: `{!! session('error_change') !!}`,
                icon: "error"
            });
        </script>
    @endif
@endpush
