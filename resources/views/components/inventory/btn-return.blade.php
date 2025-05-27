@props(['target'])

<button data-modal-target="{{ $target }}" data-modal-toggle="{{ $target }}" type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm text-white transition-all duration-200 transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg active:shadow-sm active:bg-blue-700 focus:outline-none focus:border-blue-700 active:translate-y-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
    </svg>
</button>
