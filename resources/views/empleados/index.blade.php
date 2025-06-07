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

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<!-- Estadísticas rápidas -->
<div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Empleados</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $empleados->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Activos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $empleados->where('activo', true)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Inactivos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $empleados->where('activo', false)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Departamentos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $empleados->pluck('departamento_id')->unique()->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">Número</th>
                <th class="py-3 px-6 text-left">Nombre Completo</th>
                <th class="py-3 px-6 text-left">Correo</th>
                <th class="py-3 px-6 text-left">Puesto</th>
                <th class="py-3 px-6 text-left">Departamento</th>
                <th class="py-3 px-6 text-center">Estado</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse ($empleados as $empleado)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 font-medium">{{ $empleado->num_empleado }}</td>
                    <td class="py-3 px-6">
                        <div class="flex items-center">
                            @if($empleado->foto)
                                <img src="{{ Storage::url($empleado->foto) }}" alt="Foto" class="w-8 h-8 rounded-full mr-3 object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-300 rounded-full mr-3 flex items-center justify-center">
                                    <span class="text-xs text-gray-600">{{ substr($empleado->nombres, 0, 1) }}{{ substr($empleado->apellido_paterno, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium">{{ $empleado->nombres }} {{ $empleado->apellido_paterno }}</div>
                                @if($empleado->apellido_materno)
                                    <div class="text-xs text-gray-500">{{ $empleado->apellido_materno }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        @if($empleado->email)
                            <a href="mailto:{{ $empleado->email }}" class="text-blue-600 hover:underline">{{ $empleado->email }}</a>
                        @else
                            <span class="text-gray-400">Sin correo</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">{{ $empleado->puesto->nombre ?? 'Sin puesto' }}</td>
                    <td class="py-3 px-6">{{ $empleado->departamento->nombre ?? 'Sin departamento' }}</td>
                    <td class="py-3 px-6 text-center">
                        @if($empleado->activo)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('empleados.show', $empleado) }}" 
                               class="text-green-600 hover:text-green-800 font-medium" 
                               title="Ver detalles">
                                Ver
                            </a>
                            <a href="{{ route('empleados.edit', $empleado) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium" 
                               title="Editar">
                                Editar
                            </a>
                            <form action="{{ route('empleados.destroy', $empleado) }}" 
                                  method="POST" 
                                  class="inline-block" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar a {{ $empleado->nombres }} {{ $empleado->apellido_paterno }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 font-medium" 
                                        title="Eliminar">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-lg font-medium">No hay empleados registrados</p>
                            <p class="text-sm">Comienza agregando tu primer empleado</p>
                            <a href="{{ route('empleados.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Crear Empleado
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($empleados->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $empleados->links() }}
    </div>
@endif

@endsection