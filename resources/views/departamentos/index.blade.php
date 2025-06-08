@extends('layouts.app')

@section('title', 'Lista de Departamentos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-700">Departamentos</h2>
    <div class="flex space-x-3">
        <a href="{{ route('departamentos.pdf', request()->query()) }}" 
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition flex items-center gap-2"
           title="Generar PDF">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Exportar PDF
        </a>
        <a href="{{ route('departamentos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Nuevo Departamento</a>
    </div>
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

<!-- Filtros de Búsqueda -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form method="GET" action="{{ route('departamentos.index') }}" class="space-y-4">
        <div class="flex flex-wrap items-end gap-4">
            <!-- Búsqueda por nombre -->
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar por nombre o código</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar departamento..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Filtro por jefe -->
            <div class="min-w-48">
                <label for="jefe" class="block text-sm font-medium text-gray-700 mb-2">Jefe de Departamento</label>
                <select name="jefe_id" id="jefe" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos los jefes</option>
                    @foreach($jefes as $jefe)
                        <option value="{{ $jefe->id }}" {{ request('jefe_id') == $jefe->id ? 'selected' : '' }}>
                            {{ $jefe->nombres }} {{ $jefe->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por estado -->
            <div class="min-w-36">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="activo" id="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Buscar
                </button>
                <a href="{{ route('departamentos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Limpiar
                </a>
            </div>
        </div>

        <!-- Mostrar filtros activos -->
        @if(request()->hasAny(['search', 'jefe_id', 'activo']))
            <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200">
                <span class="text-sm text-gray-600">Filtros activos:</span>
                
                @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Búsqueda: "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </span>
                @endif

                @if(request('jefe_id'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Jefe: {{ $jefes->find(request('jefe_id'))->nombres ?? 'Desconocido' }} {{ $jefes->find(request('jefe_id'))->apellido_paterno ?? '' }}
                        <a href="{{ request()->fullUrlWithQuery(['jefe_id' => null]) }}" class="ml-2 text-green-600 hover:text-green-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </span>
                @endif

                @if(request('activo') !== null)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Estado: {{ request('activo') === '1' ? 'Activos' : 'Inactivos' }}
                        <a href="{{ request()->fullUrlWithQuery(['activo' => null]) }}" class="ml-2 text-yellow-600 hover:text-yellow-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </span>
                @endif
            </div>
        @endif
    </form>
</div>

<!-- Estadísticas rápidas -->
<div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Departamentos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $departamentos->total() }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ $departamentos->where('activo', true)->count() }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ $departamentos->where('activo', false)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Con Jefe</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $departamentos->whereNotNull('jefe_id')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Resultados de búsqueda -->
@if(request()->hasAny(['search', 'jefe_id', 'activo']))
    <div class="mb-4 text-sm text-gray-600">
        Mostrando {{ $departamentos->count() }} de {{ $departamentos->total() }} departamentos
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">Código</th>
                <th class="py-3 px-6 text-left">Nombre</th>
                <th class="py-3 px-6 text-left">Descripción</th>
                <th class="py-3 px-6 text-left">Jefe</th>
                <th class="py-3 px-6 text-center">Empleados</th>
                <th class="py-3 px-6 text-center">Estado</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse ($departamentos as $departamento)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 font-medium">{{ $departamento->codigo }}</td>
                    <td class="py-3 px-6">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full mr-3 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium">{{ $departamento->nombre }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="max-w-xs">
                            <p class="text-sm text-gray-600 truncate" title="{{ $departamento->descripcion }}">
                                {{ $departamento->descripcion ?: 'Sin descripción' }}
                            </p>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        @if($departamento->jefe)
                            <div class="flex items-center">
                                @if($departamento->jefe->foto)
                                    <img src="{{ Storage::url($departamento->jefe->foto) }}" alt="Foto" class="w-6 h-6 rounded-full mr-2 object-cover">
                                @else
                                    <div class="w-6 h-6 bg-gray-300 rounded-full mr-2 flex items-center justify-center">
                                        <span class="text-xs text-gray-600">{{ substr($departamento->jefe->nombres, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="text-sm">{{ $departamento->jefe->nombres }} {{ $departamento->jefe->apellido_paterno }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">Sin asignar</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $departamento->empleados_count ?? 0 }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($departamento->activo)
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
                            <a href="{{ route('departamentos.show', $departamento) }}" 
                               class="text-green-600 hover:text-green-800 font-medium" 
                               title="Ver detalles">
                                Ver
                            </a>
                            <a href="{{ route('departamentos.edit', $departamento) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium" 
                               title="Editar">
                                Editar
                            </a>
                            <form action="{{ route('departamentos.destroy', $departamento) }}" 
                                  method="POST" 
                                  class="inline-block" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar el departamento {{ $departamento->nombre }}?');">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            @if(request()->hasAny(['search', 'jefe_id', 'activo']))
                                <p class="text-lg font-medium">No se encontraron departamentos</p>
                                <p class="text-sm">Intenta ajustar los filtros de búsqueda</p>
                                <a href="{{ route('departamentos.index') }}" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                                    Ver todos los departamentos
                                </a>
                            @else
                                <p class="text-lg font-medium">No hay departamentos registrados</p>
                                <p class="text-sm">Comienza agregando tu primer departamento</p>
                                <a href="{{ route('departamentos.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                    Crear Departamento
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($departamentos->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $departamentos->appends(request()->query())->links() }}
    </div>
@endif

@endsection