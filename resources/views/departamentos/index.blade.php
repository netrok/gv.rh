@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Departamentos</h2>
        <a href="{{ route('departamentos.create') }}"
            class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            + Nuevo Departamento
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Descripción</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($departamentos as $departamento)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $departamento->nombre }}</td>
                        <td class="px-4 py-2">{{ $departamento->descripcion }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('departamentos.edit', $departamento->id) }}"
                                class="inline-block px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                                Editar
                            </a>
                            <form action="{{ route('departamentos.destroy', $departamento->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de eliminar este departamento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            No hay departamentos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
