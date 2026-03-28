<x-app-layout>
    <x-slot name="header">Movimientos de Stock</x-slot>

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Historial de Movimientos</h2>
            <a href="{{ route('stock-movements.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Movimiento
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" action="{{ route('stock-movements.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Producto --}}
                <div>
                    <label for="product_id" class="block text-xs font-medium text-gray-500 mb-1">Producto</label>
                    <select name="product_id" id="product_id"
                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Todos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label for="type" class="block text-xs font-medium text-gray-500 mb-1">Tipo</label>
                    <select name="type" id="type"
                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Todos</option>
                        <option value="entry" {{ request('type') === 'entry' ? 'selected' : '' }}>Entrada</option>
                        <option value="exit" {{ request('type') === 'exit' ? 'selected' : '' }}>Salida</option>
                        <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Ajuste</option>
                    </select>
                </div>

                {{-- Desde --}}
                <div>
                    <label for="from" class="block text-xs font-medium text-gray-500 mb-1">Desde</label>
                    <input type="date" name="from" id="from" value="{{ request('from') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                </div>

                {{-- Hasta --}}
                <div>
                    <label for="to" class="block text-xs font-medium text-gray-500 mb-1">Hasta</label>
                    <input type="date" name="to" id="to" value="{{ request('to') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                </div>

                {{-- Boton --}}
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('stock-movements.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Anterior</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Nuevo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $movement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $movement->product->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $movement->type_color }}-100 text-{{ $movement->type_color }}-800">
                                        {{ $movement->type_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium
                                    {{ $movement->type === 'entry' ? 'text-green-600' : ($movement->type === 'exit' ? 'text-red-600' : 'text-blue-600') }}">
                                    @if($movement->type === 'entry')
                                        +{{ $movement->quantity }}
                                    @elseif($movement->type === 'exit')
                                        -{{ $movement->quantity }}
                                    @else
                                        {{ $movement->quantity }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600">
                                    {{ $movement->previous_stock }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600">
                                    {{ $movement->new_stock }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                    {{ $movement->reason ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $movement->user->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-sm font-medium">No se encontraron movimientos</p>
                                        <p class="text-xs mt-1">Registra un nuevo movimiento de stock para comenzar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($movements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
