<x-app-layout>
    <x-slot name="header">Categorías</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header row --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <form method="GET" action="{{ route('categories.index') }}" class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar categoría..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 text-sm">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Categoría
            </a>
        </div>

        {{-- Table card --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if($categories->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productos</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $category->description ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $category->products_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="text-amber-600 hover:text-amber-800 transition">
                                            Editar
                                        </a>

                                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                              x-data
                                              @submit.prevent="if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="mt-4 text-gray-500 text-sm">No se encontraron categorías.</p>
                    <a href="{{ route('categories.create') }}" class="mt-2 inline-block text-amber-600 hover:text-amber-800 text-sm font-medium">
                        Crear la primera categoría
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
