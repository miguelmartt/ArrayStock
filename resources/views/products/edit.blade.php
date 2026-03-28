<x-app-layout>
    <x-slot name="header">
        Editar Producto
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('sku')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoria --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Seleccionar categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Unidad --}}
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Unidad <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" required
                               placeholder="ej: unidad, litro, kg"
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('unit')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Costo --}}
                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">Costo <span class="text-red-500">*</span></label>
                        <input type="number" name="cost" id="cost" value="{{ old('cost', $product->cost) }}" step="0.01" min="0" required
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('cost')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stock minimo --}}
                    <div>
                        <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1">Stock minimo <span class="text-red-500">*</span></label>
                        <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', $product->min_stock) }}" min="0" required
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @error('min_stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notas --}}
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('notes', $product->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Activo --}}
                    <div class="md:col-span-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                   @checked(old('active', $product->active))
                                   class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                            <span class="text-sm text-gray-700">Producto activo</span>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
