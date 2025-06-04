@extends('layouts.app')

@section('content')
    <x-index-list
        title="Listado de Puestos"
        :routeCreate="route('puestos.create')"
        :routeIndex="route('puestos.index')"
        :items="$puestos"
        entityName="Puesto"
    >
        <x-slot name="thead">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clave</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salario Base</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($puestos as $puesto)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $puesto->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $puesto->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $puesto->clave ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($puesto->salario_base, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $puesto->departamento ? $puesto->departamento->nombre : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('puestos.edit', $puesto) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                        <form action="{{ route('puestos.destroy', $puesto) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro de eliminar este puesto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No se encontraron puestos.</td>
                </tr>
            @endforelse
        </x-slot>
    </x-index-list>
@endsection
