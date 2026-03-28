<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>Productos</span>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Producto
            </a>
        </div>
    </x-slot>

    {{-- Filter bar --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6"
         x-data="{
             submitForm() {
                 $refs.filterForm.submit();
             }
         }">
        <form method="GET" action="{{ route('products.index') }}" x-ref="filterForm"
              class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            {{-- Search --}}
            <div class="flex-1 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar por nombre o SKU..."
                       class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Category filter --}}
            <div class="w-full sm:w-48">
                <select name="category_id"
                        @change="submitForm()"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Todas las categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Low stock toggle --}}
            <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer whitespace-nowrap">
                <input type="checkbox" name="low_stock" value="1"
                       @checked(request('low_stock'))
                       @change="submitForm()"
                       class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                Stock bajo
            </label>

            {{-- Submit --}}
            <button type="submit"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Buscar
            </button>

            @if(request()->hasAny(['search', 'category_id', 'low_stock']))
                <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($products->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-600">Nombre</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Categoria</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-right">Stock</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-right">Precio</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-center">Estado</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Nombre --}}
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                    @if($product->sku)
                                        <div class="text-xs text-gray-400">SKU: {{ $product->sku }}</div>
                                    @endif
                                </td>

                                {{-- Categoria --}}
                                <td class="px-4 py-3">
                                    @if($product->category)
                                        <span class="inline-flex items-center gap-1.5 text-sm text-gray-700">
                                            <span class="w-2.5 h-2.5 rounded-full shrink-0"
                                                  style="background-color: {{ $product->category->color ?? '#9ca3af' }}"></span>
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Sin categoria</span>
                                    @endif
                                </td>

                                {{-- Stock --}}
                                <td class="px-4 py-3 text-right">
                                    @if($product->isLowStock())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-red-100 text-red-700">
                                            {{ $product->stock }} {{ $product->unit }}
                                        </span>
                                    @else
                                        <span class="text-gray-700">{{ $product->stock }} {{ $product->unit }}</span>
                                    @endif
                                </td>

                                {{-- Precio --}}
                                <td class="px-4 py-3 text-right text-gray-700">
                                    ${{ number_format($product->price, 2) }}
                                </td>

                                {{-- Estado --}}
                                <td class="px-4 py-3 text-center">
                                    @if($product->active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td class="px-4 py-3 text-right" x-data>
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="text-gray-500 hover:text-amber-600 transition" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                              @submit.prevent="if (confirm('¿Estás seguro de eliminar este producto?')) $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-gray-500 text-sm mb-4">No se encontraron productos.</p>
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                    Crear primer producto
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
