<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-gray-900 z-30">
    @include('layouts.sidebar-content')
</aside>

<!-- Mobile Sidebar -->
<aside x-show="sidebarOpen"
       x-transition:enter="transition ease-in-out duration-300 transform"
       x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300 transform"
       x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
       class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-40 lg:hidden flex flex-col">
    <div class="absolute top-4 right-4">
        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @include('layouts.sidebar-content')
</aside>
