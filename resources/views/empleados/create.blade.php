@extends('layouts.app')

@section('title', 'Crear Empleado')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Crear Nuevo Empleado</h2>

    <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Número de empleado -->
            <div>
                <label for="num_empleado" class="block text-sm font-medium text-gray-700">
                    Número de Empleado <span class="text-red-500">*</span>
                </label>
                <input type="text" name="num_empleado" id="num_empleado" value="{{ old('num_empleado') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('num_empleado') border-red-500 @enderror">
                @error('num_empleado')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Nombres -->
            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-500">*</span></label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                @error('nombres')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Apellido paterno -->
            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno <span class="text-red-500">*</span></label>
                <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ old('apellido_paterno') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellido_paterno') border-red-500 @enderror">
                @error('apellido_paterno')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Apellido materno -->
            <div>
                <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno" value="{{ old('apellido_materno') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Fecha nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Género -->
            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">Género <span class="text-red-500">*</span></label>
                <select name="genero" id="genero" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Seleccione</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <!-- Estado civil -->
            <div>
                <label for="estado_civil" class="block text-sm font-medium text-gray-700">Estado Civil</label>
                <input type="text" name="estado_civil" id="estado_civil" value="{{ old('estado_civil') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- CURP, RFC, NSS -->
            <div>
                <label for="curp" class="block text-sm font-medium text-gray-700">CURP</label>
                <input type="text" name="curp" id="curp" value="{{ old('curp') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                <input type="text" name="rfc" id="rfc" value="{{ old('rfc') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700">NSS</label>
                <input type="text" name="nss" id="nss" value="{{ old('nss') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Teléfono y email -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Puesto y Departamento -->
            <div>
                <label for="puesto_id" class="block text-sm font-medium text-gray-700">Puesto <span class="text-red-500">*</span></label>
                <select name="puesto_id" id="puesto_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Seleccione</option>
                    @foreach ($puestos as $puesto)
                        <option value="{{ $puesto->id }}" {{ old('puesto_id') == $puesto->id ? 'selected' : '' }}>{{ $puesto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento <span class="text-red-500">*</span></label>
                <select name="departamento_id" id="departamento_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Seleccione</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}" {{ old('departamento_id') == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Jefe directo -->
            <div>
                <label for="jefe_id" class="block text-sm font-medium text-gray-700">Jefe Directo</label>
                <select name="jefe_id" id="jefe_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Ninguno</option>
                    @foreach ($jefes as $jefe)
                        <option value="{{ $jefe->id }}" {{ old('jefe_id') == $jefe->id ? 'selected' : '' }}>
                            {{ $jefe->nombres }} {{ $jefe->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha de ingreso -->
            <div>
                <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Activo -->
            <div class="flex items-center mt-4">
                <input type="checkbox" name="activo" id="activo" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ old('activo') ? 'checked' : '' }}>
                <label for="activo" class="ml-2 block text-sm text-gray-700">Activo</label>
            </div>

            <!-- Foto -->
            <div class="mt-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="inline-flex justify-center px-6 py-2 text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                Guardar
            </button>
            <a href="{{ route('empleados.index') }}"
                class="ml-4 inline-flex justify-center px-6 py-2 text-indigo-700 bg-white border border-indigo-300 rounded-md shadow-sm hover:bg-indigo-50">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
