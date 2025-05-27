@props(['target'])

<button data-modal-target="{{ $target }}" data-modal-toggle="{{ $target }}" type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-md hover:bg-red-600 hover:shadow-lg active:shadow-sm active:bg-red-700 focus:outline-none focus:border-red-700 active:translate-y-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
    </svg>
</button>
