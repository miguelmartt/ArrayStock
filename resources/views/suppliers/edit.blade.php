<x-app-layout>
    <x-slot name="header">Editar Proveedor</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required
                               class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Persona de contacto --}}
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">Persona de Contacto</label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        @error('contact_person')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telefono --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefono</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Direccion --}}
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Direccion</label>
                        <textarea name="address" id="address" rows="2"
                                  class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notas --}}
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">{{ old('notes', $supplier->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Activo --}}
                    <div class="md:col-span-2">
                        <label class="inline-flex items-center gap-2">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" {{ old('active', $supplier->active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                            <span class="text-sm font-medium text-gray-700">Activo</span>
                        </label>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('suppliers.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition">
                        Actualizar Proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
