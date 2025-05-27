@props(['target', 'action'])

<div id="{{ $target }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white border-l-4 border-blue-500 rounded-lg shadow-xl">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="{{ $target }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-16 h-16 mb-4 text-blue-500 bg-blue-100 rounded-full">
                        <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="mb-5 text-lg font-medium text-gray-800">Are you sure you want to return this item?</h3>
                    <div class="flex justify-center gap-4">
                        <form action="{{ $action }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, return it
                            </button>
                        </form>
                        <button data-modal-hide="{{ $target }}" type="button" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            No, cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
