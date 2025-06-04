@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Editar Empleado</h1>

    <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Num Empleado -->
            <div>
                <label for="num_empleado" class="block text-sm font-medium text-gray-700">Número de Empleado<span class="text-red-600">*</span></label>
                <input type="text" name="num_empleado" id="num_empleado" value="{{ old('num_empleado', $empleado->num_empleado) }}" 
                    class="mt-1 block w-full rounded-md border @error('num_empleado') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('num_empleado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombres -->
            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres<span class="text-red-600">*</span></label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $empleado->nombres) }}" 
                    class="mt-1 block w-full rounded-md border @error('nombres') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('nombres')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellido Paterno -->
            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno<span class="text-red-600">*</span></label>
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

            <!-- Fecha Nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento<span class="text-red-600">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento->format('Y-m-d')) }}" 
                    class="mt-1 block w-full rounded-md border @error('fecha_nacimiento') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fecha_nacimiento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Género -->
            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">Género<span class="text-red-600">*</span></label>
                <select name="genero" id="genero" class="mt-1 block w-full rounded-md border @error('genero') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>Selecciona</option>
                    <option value="Masculino" {{ old('genero', $empleado->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero', $empleado->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('genero', $empleado->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('genero')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado Civil -->
            <div>
                <label for="estado_civil" class="block text-sm font-medium text-gray-700">Estado Civil</label>
                <input type="text" name="estado_civil" id="estado_civil" value="{{ old('estado_civil', $empleado->estado_civil) }}" 
                    class="mt-1 block w-full rounded-md border @error('estado_civil') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('estado_civil')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- CURP -->
            <div>
                <label for="curp" class="block text-sm font-medium text-gray-700">CURP</label>
                <input type="text" name="curp" id="curp" value="{{ old('curp', $empleado->curp) }}" 
                    class="mt-1 block w-full rounded-md border @error('curp') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="18">
                @error('curp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- RFC -->
            <div>
                <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                <input type="text" name="rfc" id="rfc" value="{{ old('rfc', $empleado->rfc) }}" 
                    class="mt-1 block w-full rounded-md border @error('rfc') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="13">
                @error('rfc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- NSS -->
            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700">NSS</label>
                <input type="text" name="nss" id="nss" value="{{ old('nss', $empleado->nss) }}" 
                    class="mt-1 block w-full rounded-md border @error('nss') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="11">
                @error('nss')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" 
                    class="mt-1 block w-full rounded-md border @error('telefono') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="15">
                @error('telefono')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $empleado->email) }}" 
                    class="mt-1 block w-full rounded-md border @error('email') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Puesto -->
            <div>
                <label for="puesto_id" class="block text-sm font-medium text-gray-700">Puesto<span class="text-red-600">*</span></label>
                <select name="puesto_id" id="puesto_id" 
                    class="mt-1 block w-full rounded-md border @error('puesto_id') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>Selecciona un puesto</option>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id }}" {{ old('puesto_id', $empleado->puesto_id) == $puesto->id ? 'selected' : '' }}>
                            {{ $puesto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('puesto_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Departamento -->
            <div>
                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento<span class="text-red-600">*</span></label>
                <select name="departamento_id" id="departamento_id" 
                    class="mt-1 block w-full rounded-md border @error('departamento_id') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>Selecciona un departamento</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ old('departamento_id', $empleado->departamento_id) == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('departamento_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha Ingreso -->
            <div>
                <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso<span class="text-red-600">*</span></label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso', $empleado->fecha_ingreso->format('Y-m-d')) }}" 
                    class="mt-1 block w-full rounded-md border @error('fecha_ingreso') border-red-500 @else border-gray-300 @enderror shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fecha_ingreso')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Activo -->
            <div class="flex items-center mt-6 md:col-span-3">
                <input type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $empleado->activo) ? 'checked' : '' }} 
                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="activo" class="ml-2 block text-sm text-gray-700">Activo</label>
            </div>

            <!-- Foto -->
            <div class="md:col-span-3">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" 
                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:bg-indigo-50 file:text-indigo-700 file:border-0 file:rounded file:mr-4 file:py-2 file:px-4">
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if($empleado->foto)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Foto actual:</p>
                        <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto empleado" class="h-24 w-24 object-cover rounded">
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-8">
            <button type="submit" 
                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Actualizar
            </button>
            <a href="{{ route('empleados.index') }}" 
                class="inline-flex justify-center py-2 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
