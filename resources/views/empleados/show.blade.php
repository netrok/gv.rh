@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Detalles del Empleado</h2>
        <div class="flex space-x-2">
            <a href="{{ route('empleados.edit', $empleado) }}"
                class="inline-flex justify-center px-4 py-2 text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
            </a>
            <a href="{{ route('empleados.pdf', $empleado) }}" target="_blank"
                class="inline-flex justify-center px-4 py-2 text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Generar PDF
            </a>
            <a href="{{ route('empleados.index') }}"
                class="inline-flex justify-center px-4 py-2 text-indigo-700 bg-white border border-indigo-300 rounded-md shadow-sm hover:bg-indigo-50">
                Volver
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Foto del empleado -->
        <div class="lg:col-span-1">
            <div class="text-center">
                @if($empleado->foto)
                    <img src="{{ asset('storage/' . $empleado->foto) }}" 
                         alt="Foto de {{ $empleado->nombres }}"
                         class="w-48 h-48 mx-auto rounded-lg object-cover shadow-md">
                @else
                    <div class="w-48 h-48 mx-auto bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $empleado->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <span class="w-2 h-2 mr-2 rounded-full {{ $empleado->activo ? 'bg-green-400' : 'bg-red-400' }}"></span>
                        {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Información del empleado -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                
                <!-- Información Personal -->
                <div class="md:col-span-2 xl:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Información Personal</h3>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Número de Empleado</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ $empleado->num_empleado }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Nombres</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->nombres }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Apellido Paterno</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->apellido_paterno }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Apellido Materno</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->apellido_materno ?? 'No especificado' }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Edad</dt>
                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->age }} años</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Género</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->genero }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Estado Civil</dt>
                    <dd class="text-sm text-gray-900">{{ str_replace('_', ' ', $empleado->estado_civil) }}</dd>
                </div>

                <!-- Información Legal -->
                <div class="md:col-span-2 xl:col-span-3 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Información Legal</h3>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">CURP</dt>
                    <dd class="text-sm text-gray-900 font-mono">{{ $empleado->curp }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">RFC</dt>
                    <dd class="text-sm text-gray-900 font-mono">{{ $empleado->rfc }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">NSS</dt>
                    <dd class="text-sm text-gray-900 font-mono">{{ $empleado->nss ?? 'No especificado' }}</dd>
                </div>

                <!-- Información de Contacto -->
                <div class="md:col-span-2 xl:col-span-3 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Información de Contacto</h3>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                    <dd class="text-sm text-gray-900">
                        @if($empleado->telefono)
                            <a href="tel:{{ $empleado->telefono }}" class="text-indigo-600 hover:text-indigo-500">
                                {{ $empleado->telefono }}
                            </a>
                        @else
                            No especificado
                        @endif
                    </dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                    <dd class="text-sm text-gray-900">
                        <a href="mailto:{{ $empleado->email }}" class="text-indigo-600 hover:text-indigo-500">
                            {{ $empleado->email }}
                        </a>
                    </dd>
                </div>

                <!-- Información Laboral -->
                <div class="md:col-span-2 xl:col-span-3 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Información Laboral</h3>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Puesto</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->puesto->nombre ?? 'No asignado' }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                    <dd class="text-sm text-gray-900">{{ $empleado->departamento->nombre ?? 'No asignado' }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Jefe Directo</dt>
                    <dd class="text-sm text-gray-900">
                        @if($empleado->jefe)
                            <a href="{{ route('empleados.show', $empleado->jefe) }}" class="text-indigo-600 hover:text-indigo-500">
                                {{ $empleado->jefe->nombres }} {{ $empleado->jefe->apellido_paterno }}
                            </a>
                        @else
                            No asignado
                        @endif
                    </dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Antigüedad</dt>
                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->diffForHumans() }}</dd>
                </div>

                <div class="space-y-1">
                    <dt class="text-sm font-medium text-gray-500">Tiempo en la empresa</dt>
                    <dd class="text-sm text-gray-900">
                        @php
                            $fechaIngreso = \Carbon\Carbon::parse($empleado->fecha_ingreso);
                            $años = $fechaIngreso->diffInYears(now());
                            $meses = $fechaIngreso->copy()->addYears($años)->diffInMonths(now());
                        @endphp
                        {{ $años }} años, {{ $meses }} meses
                    </dd>
                </div>
            </div>

            <!-- Empleados a cargo (si es jefe) -->
            @if($empleado->subordinados && $empleado->subordinados->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Empleados a Cargo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($empleado->subordinados as $subordinado)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($subordinado->foto)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $subordinado->foto) }}" alt="{{ $subordinado->nombres }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('empleados.show', $subordinado) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                            {{ $subordinado->nombres }} {{ $subordinado->apellido_paterno }}
                                        </a>
                                        <p class="text-xs text-gray-500">{{ $subordinado->puesto->nombre ?? 'Sin puesto' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection