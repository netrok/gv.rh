@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Editar Empleado</h1>

    <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Número de Empleado -->
            <div>
                <label for="num_empleado" class="block text-sm font-medium text-gray-700">Número de Empleado <span class="text-red-600">*</span></label>
                <input type="text" name="num_empleado" id="num_empleado" value="{{ old('num_empleado', $empleado->num_empleado) }}"
                    class="mt-1 block w-full rounded-md border @error('num_empleado') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('num_empleado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombres -->
            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-600">*</span></label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $empleado->nombres) }}"
                    class="mt-1 block w-full rounded-md border @error('nombres') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('nombres')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellido Paterno -->
            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno <span class="text-red-600">*</span></label>
                <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ old('apellido_paterno', $empleado->apellido_paterno) }}"
                    class="mt-1 block w-full rounded-md border @error('apellido_paterno') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('apellido_paterno')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellido Materno -->
            <div>
                <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno" value="{{ old('apellido_materno', $empleado->apellido_materno) }}"
                    class="mt-1 block w-full rounded-md border @error('apellido_materno') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('apellido_materno')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jefe Inmediato -->
            <div>
                <label for="jefe_id" class="block text-sm font-medium text-gray-700">Jefe Inmediato</label>
                <select name="jefe_id" id="jefe_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">-- Seleccionar Jefe --</option>
                    @foreach ($jefes as $jefe)
                        <option value="{{ $jefe->id }}" {{ old('jefe_id', $empleado->jefe_id) == $jefe->id ? 'selected' : '' }}>
                            {{ $jefe->nombres }} {{ $jefe->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
                @error('jefe_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                @if ($empleado->foto)
                    <img src="{{ asset('storage/fotos/' . $empleado->foto) }}" alt="Foto actual" class="mt-2 h-16 rounded">
                @endif
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-6">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Guardar Cambios
            </button>
            <a href="{{ route('empleados.index') }}"
                class="ml-4 text-sm text-gray-600 hover:text-gray-900 underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
