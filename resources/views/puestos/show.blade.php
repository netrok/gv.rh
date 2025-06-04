@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-8">
    <h1 class="text-2xl font-semibold mb-6">Detalle del Puesto</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-sm text-gray-500">Nombre</h2>
            <p class="text-lg text-gray-900">{{ $puesto->nombre }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Clave</h2>
            <p class="text-lg text-gray-900">{{ $puesto->clave ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Departamento</h2>
            <p class="text-lg text-gray-900">{{ $puesto->departamento->nombre ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Salario Base</h2>
            <p class="text-lg text-gray-900">
                {{ $puesto->salario_base !== null ? '$' . number_format($puesto->salario_base, 2) : '-' }}
            </p>
        </div>

        <div class="md:col-span-2">
            <h2 class="text-sm text-gray-500">Descripción</h2>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $puesto->descripcion ?? '-' }}
            </p>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-2">
        <a href="{{ route('puestos.index') }}"
           class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Volver</a>

        <a href="{{ route('puestos.edit', $puesto) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
    </div>
</div>
@endsection
