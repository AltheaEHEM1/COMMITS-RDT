@props(['onclick' => null])

<button type="button"
    @if($onclick) onclick="{{ $onclick }}" @endif
    class="inline-flex items-center gap-2 px-3 py-2 text-sm text-white transition-all duration-200 transform bg-green-500 rounded-lg shadow-md hover:bg-green-600 hover:shadow-lg active:shadow-sm active:bg-green-700 focus:outline-none focus:border-green-700 active:translate-y-0"
    title="View"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-9 9-9 9s-9-4-9-9a9 9 0 0118 0z" />
    </svg>
</button>