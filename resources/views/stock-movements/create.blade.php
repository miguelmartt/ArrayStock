<x-app-layout>
    <x-slot name="header">Nuevo Movimiento</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('stock-movements.store') }}">
                @csrf

                <div class="space-y-6">
                    {{-- Producto --}}
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Producto <span class="text-red-500">*</span></label>
                        <select name="product_id" id="product_id" required
                                class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Seleccionar producto...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                                class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Seleccionar tipo...</option>
                            <option value="entry" {{ old('type') === 'entry' ? 'selected' : '' }}>Entrada</option>
                            <option value="exit" {{ old('type') === 'exit' ? 'selected' : '' }}>Salida</option>
                            <option value="adjustment" {{ old('type') === 'adjustment' ? 'selected' : '' }}>Ajuste</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cantidad --}}
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Cantidad <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" required
                               class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Motivo --}}
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
                        <textarea name="reason" id="reason" rows="3"
                                  class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('stock-movements.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
