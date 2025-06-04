@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-white shadow rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Detalle del Empleado</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Foto del empleado si tienes -->
        @if($empleado->foto_url)
        <div class="col-span-1 flex justify-center items-center">
            <img src="{{ $empleado->foto_url }}" alt="Foto de {{ $empleado->nombres }}" class="rounded-full w-32 h-32 object-cover border border-gray-300">
        </div>
        @endif

        <div class="col-span-1 md:col-span-2 space-y-4">
            <p><strong class="text-gray-700">Número de Empleado:</strong> {{ $empleado->num_empleado }}</p>
            <p><strong class="text-gray-700">Nombre Completo:</strong> {{ $empleado->nombres }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</p>
            <p><strong class="text-gray-700">Fecha de Nacimiento:</strong> {{ $empleado->fecha_nacimiento->format('d/m/Y') }}</p>
            <p><strong class="text-gray-700">Género:</strong> {{ $empleado->genero }}</p>
            <p><strong class="text-gray-700">Estado Civil:</strong> {{ $empleado->estado_civil ?? 'N/A' }}</p>
            <p><strong class="text-gray-700">CURP:</strong> {{ $empleado->curp ?? 'N/A' }}</p>
            <p><strong class="text-gray-700">RFC:</strong> {{ $empleado->rfc ?? 'N/A' }}</p>
            <p><strong class="text-gray-700">NSS:</strong> {{ $empleado->nss ?? 'N/A' }}</p>
            <p><strong class="text-gray-700">Teléfono:</strong> {{ $empleado->telefono ?? 'N/A' }}</p>
            <p><strong class="text-gray-700">Email:</strong> {{ $empleado->email ?? 'N/A' }}</p>
        </div>
    </div>

    <hr class="mb-6 border-gray-300" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <p><strong class="text-gray-700">Puesto:</strong> {{ $empleado->puesto->nombre ?? 'N/A' }}</p>
        <p><strong class="text-gray-700">Departamento:</strong> {{ $empleado->departamento->nombre ?? 'N/A' }}</p>
        <p><strong class="text-gray-700">Fecha de Ingreso:</strong> {{ $empleado->fecha_ingreso->format('d/m/Y') }}</p>
        <p><strong class="text-gray-700">Estado:</strong> {{ $empleado->activo ? 'Activo' : 'Inactivo' }}</p>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('empleados.index') }}" class="inline-block px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">Regresar</a>
        <a href="{{ route('empleados.edit', $empleado) }}" class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">Editar</a>
    </div>
</div>
@endsection
