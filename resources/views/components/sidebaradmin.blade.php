<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-[#7A0019] md:translate-x-0"
    aria-label="Sidenav" id="drawer-navigation">

    <div class="flex items-center px-2 py-2 border-b-2 border-red-900">
        <!-- Logo -->
        <a class="flex-none inline-block text-xl font-semibold rounded-xl focus:outline-hidden focus:opacity-80"
            href="#" aria-label="PRMS">
            <div class="flex items-center justify-start w-full">
                <!--PRMS logo-->
                <img src="{{ asset('images/prms-logo 2.jpg') }}" alt="logo" class="w-10 mr-1">
                <span class="text-2xl font-bold text-white">PRMS</span>
            </div>
        </a>
        <!-- End Logo -->

        <div class="hidden lg:block ms-2">
        </div>
    </div>

    {{-- PROFILE --}}
    <div class="flex items-center justify-start w-full px-6 py-2 mt-1">
        <div class="p-1 mr-2 bg-white border rounded-lg w-14">
            <img src="{{ asset('images/puplogo.png') }}" alt="">
        </div>
        <div class="text-white">
            <p class="text-base font-semibold">{{ auth()->user()->first_name }}</p>
            <p class="text-sm font-medium text-gray-300">{{ auth()->user()->role }}</p>
            <p class="text-xs font-semibold text-green-500">• online</p>
        </div>
    </div>

    <div class="overflow-y-auto px-3 pb-4 pt-2 h-full bg-[#7A0019]">
        <p class="mt-4 mb-2 text-sm font-semibold text-gray-300 text-start">Menu</p>
        <ul class="flex flex-col space-y-1">
            <li>
                <x-sidebar-link :href="route('Superadmin_dashboard')" :active="request()->is('Superadmin_dashboard*') || request()->is('/')" :icon="'fas fa-chart-pie'">Dashboard</x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link :href="route('users.get')" :active="request()->is('admin/users*')" :icon="'fas fa-user-injured'">User</x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link :href="route('Auditlog')" :active="request()->is('admin/activity-logs*')" :icon="'fas fa-history'">Audit log</x-sidebar-link>
            </li>
        </ul>
    </div>
   
</aside>
