@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-8">
    <h1 class="text-2xl font-semibold mb-6">Editar Puesto</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('puestos.update', $puesto) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $puesto->nombre) }}"
                   class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div>
            <label for="clave" class="block text-sm font-medium text-gray-700">Clave</label>
            <input type="text" name="clave" id="clave" value="{{ old('clave', $puesto->clave) }}"
                   class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
            <select name="departamento_id" id="departamento_id"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Selecciona --</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}"
                        {{ old('departamento_id', $puesto->departamento_id) == $departamento->id ? 'selected' : '' }}>
                        {{ $departamento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="salario_base" class="block text-sm font-medium text-gray-700">Salario Base</label>
            <input type="number" name="salario_base" id="salario_base" value="{{ old('salario_base', $puesto->salario_base) }}"
                   step="0.01" min="0"
                   class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4"
                      class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $puesto->descripcion) }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('puestos.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
