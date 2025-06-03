@extends('layouts.app')

@section('title', 'Lista de Empleados')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-700">Empleados</h2>
    <a href="{{ route('empleados.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Nuevo Empleado</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
        <tr>
            <th class="py-3 px-6 text-left">ID</th>
            <th class="py-3 px-6 text-left">Nombre</th>
            <th class="py-3 px-6 text-left">Correo</th>
            <th class="py-3 px-6 text-left">Puesto</th>
            <th class="py-3 px-6 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 text-sm">
        @forelse ($empleados as $empleado)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6">{{ $empleado->id }}</td>
                <td class="py-3 px-6">{{ $empleado->nombre }}</td>
                <td class="py-3 px-6">{{ $empleado->email }}</td>
                <td class="py-3 px-6">{{ $empleado->puesto->nombre ?? 'Sin puesto' }}</td>
                <td class="py-3 px-6 text-center">
                    <a href="{{ route('empleados.edit', $empleado) }}" class="text-blue-600 hover:text-blue-800 mr-3">Editar</a>

                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que quieres eliminar este empleado?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-gray-500">No hay empleados registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-6">
    {{ $empleados->links() }}
</div>
@endsection
