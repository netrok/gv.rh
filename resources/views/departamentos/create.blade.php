@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Crear Nuevo Departamento</h2>

    <form action="{{ route('departamentos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Ejemplo: Recursos Humanos" required>
            @error('nombre')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código del Departamento</label>
            <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Ejemplo: RH001" required>
            @error('codigo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Descripción del departamento">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jefe_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe del Departamento</label>
            <select name="jefe_id" id="jefe_id"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Seleccionar jefe (opcional) --</option>
                @foreach($jefes as $jefe)
                    <option value="{{ $jefe->id }}" {{ old('jefe_id') == $jefe->id ? 'selected' : '' }}>
                        {{ $jefe->nombre }}
                    </option>
                @endforeach
            </select>
            @error('jefe_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="activo" id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="activo" class="text-sm font-medium text-gray-700">Activo</label>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('departamentos.index') }}"
                class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Guardar Departamento
            </button>
        </div>
    </form>
</div>
@endsection
