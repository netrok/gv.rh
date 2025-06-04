@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Detalle del Departamento</h2>

    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-800">Nombre</h3>
        <p class="mt-1 text-gray-600">{{ $departamento->nombre }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-800">Descripción</h3>
        <p class="mt-1 text-gray-600 whitespace-pre-line">{{ $departamento->descripcion ?? 'Sin descripción' }}</p>
    </div>

    <div class="flex justify-end space-x-4">
        <a href="{{ route('departamentos.index') }}"
            class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
            Volver
        </a>
        <a href="{{ route('departamentos.edit', $departamento->id) }}"
            class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Editar
        </a>
    </div>
</div>
@endsection
