@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Editar Departamento</h2>

    <form action="{{ route('departamentos.update', $departamento->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $departamento->nombre) }}"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Ejemplo: Recursos Humanos" required>
            @error('nombre')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
            <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $departamento->codigo) }}"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Código del departamento" required>
            @error('codigo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Descripción del departamento">{{ old('descripcion', $departamento->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jefe_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe de Departamento</label>
            <select name="jefe_id" id="jefe_id"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Seleccione jefe --</option>
                @foreach($jefes as $jefe)
                    <option value="{{ $jefe->id }}" {{ old('jefe_id', $departamento->jefe_id) == $jefe->id ? 'selected' : '' }}>
                        {{ $jefe->nombre }} {{-- Cambia 'nombre' por el campo real del empleado --}}
                    </option>
                @endforeach
            </select>
            @error('jefe_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="activo" id="activo" value="1"
                {{ old('activo', $departamento->activo) ? 'checked' : '' }}
                class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <label for="activo" class="text-sm font-medium text-gray-700">Activo</label>
            @error('activo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('departamentos.index') }}"
                class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Actualizar Departamento
            </button>
        </div>
    </form>
</div>
@endsection
