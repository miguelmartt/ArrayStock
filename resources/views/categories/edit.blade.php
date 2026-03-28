<x-app-layout>
    <x-slot name="header">Editar Categoría</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                           class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 text-sm"
                           placeholder="Nombre de la categoría">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <input type="text" name="description" id="description" value="{{ old('description', $category->description) }}"
                           class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 text-sm"
                           placeholder="Descripción opcional">
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Color --}}
                <div class="mb-6">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}"
                           class="h-10 w-20 border-gray-300 rounded-lg cursor-pointer">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                        Guardar
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
