<div id="date-error-modal" tabindex="-1" aria-hidden="true" class="fixed mt-0 top-0 h-screen left-0 right-0 z-50 nt-0 hidden w-full overflow-x-hidden overflow-y-auto flex items-center justify-center" style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
    <div class="relative w-full max-w-sm max-h-full transition-all duration-300 transform scale-95 opacity-0" id="date-error-modal-container">
        <div class="relative overflow-hidden bg-white rounded-lg shadow-lg">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-3 bg-red-50">
                <h3 class="flex items-center text-lg font-medium text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Invalid Date
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-4 text-center">
                <div class="flex items-center justify-center w-12 h-12 p-2 mx-auto mb-3 rounded-full bg-red-50">
                    <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="mb-4 text-base font-medium text-gray-800">
                    <span id="date-error-message">The expiration date must be after the received date.</span>
                </p>
                <button type="button" onclick="closeErrorModal()" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-md px-5 py-2.5 text-sm font-medium transition-colors">
                    OK, I'll fix it
                </button>
            </div>
            <!-- Modal footer with countdown -->
            <div class="flex items-center justify-between px-4 py-3 text-xs text-gray-500 bg-gray-50">
                <span class="font-medium text-red-700" id="error-fix-message">Expiration date has been cleared</span>
                <span>Closing in <span id="error-modal-countdown" class="font-bold">5</span>s</span>
            </div>
        </div>
    </div>
</div>

<script>
    // We'll implement the JS functions later
</script>
