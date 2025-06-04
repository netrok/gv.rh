@extends('layouts.app')

@section('title', 'Crear Empleado')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Crear Nuevo Empleado</h2>

    <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label for="num_empleado" class="block text-sm font-medium text-gray-700">
                    Número de Empleado <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="num_empleado" 
                    id="num_empleado" 
                    value="{{ old('num_empleado') }}" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('num_empleado') border-red-500 @enderror"
                >
                @error('num_empleado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700">
                    Nombres <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="nombres" 
                    id="nombres" 
                    value="{{ old('nombres') }}" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror"
                >
                @error('nombres')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">
                    Apellido Paterno <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="apellido_paterno" 
                    id="apellido_paterno" 
                    value="{{ old('apellido_paterno') }}" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellido_paterno') border-red-500 @enderror"
                >
                @error('apellido_paterno')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

            <div>
                <label for="apellido_materno" class="block text-sm font-medium text-gray-700">
                    Apellido Materno
                </label>
                <input 
                    type="text" 
                    name="apellido_materno" 
                    id="apellido_materno" 
                    value="{{ old('apellido_materno') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellido_materno') border-red-500 @enderror"
                >
                @error('apellido_materno')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                    Fecha de Nacimiento <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    name="fecha_nacimiento" 
                    id="fecha_nacimiento" 
                    value="{{ old('fecha_nacimiento') }}" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_nacimiento') border-red-500 @enderror"
                >
                @error('fecha_nacimiento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">
                    Género <span class="text-red-500">*</span>
                </label>
                <select 
                    name="genero" 
                    id="genero" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('genero') border-red-500 @enderror"
                >
                    <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Selecciona género</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('genero')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

            <div>
                <label for="estado_civil" class="block text-sm font-medium text-gray-700">
                    Estado Civil
                </label>
                <input 
                    type="text" 
                    name="estado_civil" 
                    id="estado_civil" 
                    value="{{ old('estado_civil') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado_civil') border-red-500 @enderror"
                >
                @error('estado_civil')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="curp" class="block text-sm font-medium text-gray-700">
                    CURP
                </label>
                <input 
                    type="text" 
                    name="curp" 
                    id="curp" 
                    maxlength="18" 
                    value="{{ old('curp') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('curp') border-red-500 @enderror"
                >
                @error('curp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rfc" class="block text-sm font-medium text-gray-700">
                    RFC
                </label>
                <input 
                    type="text" 
                    name="rfc" 
                    id="rfc" 
                    maxlength="13" 
                    value="{{ old('rfc') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('rfc') border-red-500 @enderror"
                >
                @error('rfc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700">
                    NSS
                </label>
                <input 
                    type="text" 
                    name="nss" 
                    id="nss" 
                    maxlength="11" 
                    value="{{ old('nss') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nss') border-red-500 @enderror"
                >
                @error('nss')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">
                    Teléfono
                </label>
                <input 
                    type="text" 
                    name="telefono" 
                    id="telefono" 
                    maxlength="15" 
                    value="{{ old('telefono') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror"
                >
                @error('telefono')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-6 flex items-center space-x-6">

            <div class="flex items-center">
                <!-- Hidden input para asegurar que llegue un valor aunque no esté chequeado -->
                <input type="hidden" name="activo" value="0">
                <input 
                    type="checkbox" 
                    name="activo" 
                    id="activo" 
                    value="1" 
                    {{ old('activo') ? 'checked' : '' }} 
                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                >
                <label for="activo" class="ml-2 block text-sm text-gray-700">Activo</label>
            </div>

            <div class="flex-1">
                <label for="foto" class="block text-sm font-medium text-gray-700">
                    Foto
                </label>
                <input 
                    type="file" 
                    name="foto" 
                    id="foto" 
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-600
                    file:mr-4 file:py-2 file:px-4
                    file:border file:border-gray-300 file:rounded-md
                    file:text-sm file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100"
                >
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8">
            <button 
                type="submit" 
                class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
                Guardar
            </button>
        </div>

    </form>
</div>
@endsection
