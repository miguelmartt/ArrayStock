<!-- Logo -->
<div class="flex items-center gap-3 h-16 px-6 border-b border-gray-800">
    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <span class="text-white font-bold text-lg">ArrayStock</span>
</div>

<!-- Navigation -->
<nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Principal</p>

    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('dashboard') ? 'bg-amber-500/10 text-amber-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    <p class="px-3 pt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Inventario</p>

    <a href="{{ route('products.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('products.*') ? 'bg-amber-500/10 text-amber-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        Productos
    </a>

    <a href="{{ route('categories.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('categories.*') ? 'bg-amber-500/10 text-amber-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        Categorías
    </a>

    <a href="{{ route('stock-movements.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('stock-movements.*') ? 'bg-amber-500/10 text-amber-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
        </svg>
        Movimientos
    </a>

    <p class="px-3 pt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Gestión</p>

    <a href="{{ route('suppliers.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('suppliers.*') ? 'bg-amber-500/10 text-amber-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Proveedores
    </a>
</nav>

<!-- Footer -->
<div class="px-6 py-4 border-t border-gray-800">
    <p class="text-xs text-gray-500">ArrayStock &copy; {{ date('Y') }}</p>
</div>
