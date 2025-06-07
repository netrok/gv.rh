@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Editar Empleado: {{ $empleado->nombres }} {{ $empleado->apellido_paterno }}</h2>

    {{-- Mostrar errores si existen --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mostrar mensaje de éxito o error --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Número de empleado -->
            <div>
                <label for="num_empleado" class="block text-sm font-medium text-gray-700">
                    Número de Empleado <span class="text-red-500">*</span>
                </label>
                <input type="text" name="num_empleado" id="num_empleado" 
                    value="{{ old('num_empleado', $empleado->num_empleado) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('num_empleado') ? 'border-red-500' : 'border-gray-300' }}">
                @error('num_empleado')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Nombres -->
            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-500">*</span></label>
                <input type="text" name="nombres" id="nombres" 
                    value="{{ old('nombres', $empleado->nombres) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('nombres') ? 'border-red-500' : 'border-gray-300' }}">
                @error('nombres')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Apellido paterno -->
            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno <span class="text-red-500">*</span></label>
                <input type="text" name="apellido_paterno" id="apellido_paterno" 
                    value="{{ old('apellido_paterno', $empleado->apellido_paterno) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('apellido_paterno') ? 'border-red-500' : 'border-gray-300' }}">
                @error('apellido_paterno')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Apellido materno -->
            <div>
                <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno" 
                    value="{{ old('apellido_materno', $empleado->apellido_materno) }}"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('apellido_materno') ? 'border-red-500' : 'border-gray-300' }}">
                @error('apellido_materno')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Fecha nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                    value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('fecha_nacimiento') ? 'border-red-500' : 'border-gray-300' }}">
                @error('fecha_nacimiento')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Género -->
            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">Género <span class="text-red-500">*</span></label>
                <select name="genero" id="genero" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('genero') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Seleccione</option>
                    <option value="Masculino" {{ old('genero', $empleado->genero == 'M' ? 'Masculino' : ($empleado->genero == 'Masculino' ? 'Masculino' : '')) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero', $empleado->genero == 'F' ? 'Femenino' : ($empleado->genero == 'Femenino' ? 'Femenino' : '')) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('genero')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Estado civil -->
            <div>
                <label for="estado_civil" class="block text-sm font-medium text-gray-700">Estado Civil <span class="text-red-500">*</span></label>
                <select name="estado_civil" id="estado_civil" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('estado_civil') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Seleccione</option>
                    <option value="Soltero" {{ old('estado_civil', $empleado->estado_civil) == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                    <option value="Casado" {{ old('estado_civil', $empleado->estado_civil) == 'Casado' ? 'selected' : '' }}>Casado</option>
                    <option value="Divorciado" {{ old('estado_civil', $empleado->estado_civil) == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                    <option value="Viudo" {{ old('estado_civil', $empleado->estado_civil) == 'Viudo' ? 'selected' : '' }}>Viudo</option>
                    <option value="Union_Libre" {{ old('estado_civil', $empleado->estado_civil) == 'Union_Libre' ? 'selected' : '' }}>Unión Libre</option>
                </select>
                @error('estado_civil')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- CURP -->
            <div>
                <label for="curp" class="block text-sm font-medium text-gray-700">CURP <span class="text-red-500">*</span></label>
                <input type="text" name="curp" id="curp" 
                    value="{{ old('curp', $empleado->curp) }}" required maxlength="18"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('curp') ? 'border-red-500' : 'border-gray-300' }}">
                @error('curp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- RFC -->
            <div>
                <label for="rfc" class="block text-sm font-medium text-gray-700">RFC <span class="text-red-500">*</span></label>
                <input type="text" name="rfc" id="rfc" 
                    value="{{ old('rfc', $empleado->rfc) }}" required maxlength="13"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('rfc') ? 'border-red-500' : 'border-gray-300' }}">
                @error('rfc')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- NSS -->
            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700">NSS</label>
                <input type="text" name="nss" id="nss" 
                    value="{{ old('nss', $empleado->nss) }}" maxlength="11"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('nss') ? 'border-red-500' : 'border-gray-300' }}">
                @error('nss')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telefono" id="telefono" 
                    value="{{ old('telefono', $empleado->telefono) }}" maxlength="15"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('telefono') ? 'border-red-500' : 'border-gray-300' }}">
                @error('telefono')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" 
                    value="{{ old('email', $empleado->email) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Puesto -->
            <div>
                <label for="puesto_id" class="block text-sm font-medium text-gray-700">Puesto <span class="text-red-500">*</span></label>
                <select name="puesto_id" id="puesto_id" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('puesto_id') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Seleccione</option>
                    @foreach ($puestos as $puesto)
                        <option value="{{ $puesto->id }}" {{ old('puesto_id', $empleado->puesto_id) == $puesto->id ? 'selected' : '' }}>
                            {{ $puesto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('puesto_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Departamento -->
            <div>
                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento <span class="text-red-500">*</span></label>
                <select name="departamento_id" id="departamento_id" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('departamento_id') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Seleccione</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}" {{ old('departamento_id', $empleado->departamento_id) == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('departamento_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Jefe directo -->
            <div>
                <label for="jefe_id" class="block text-sm font-medium text-gray-700">Jefe Directo</label>
                <select name="jefe_id" id="jefe_id"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('jefe_id') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Ninguno</option>
                    @foreach ($jefes as $jefe)
                        <option value="{{ $jefe->id }}" {{ old('jefe_id', $empleado->jefe_id) == $jefe->id ? 'selected' : '' }}>
                            {{ $jefe->nombres }} {{ $jefe->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
                @error('jefe_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Fecha de ingreso -->
            <div>
                <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" 
                    value="{{ old('fecha_ingreso', $empleado->fecha_ingreso) }}" required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('fecha_ingreso') ? 'border-red-500' : 'border-gray-300' }}">
                @error('fecha_ingreso')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Activo -->
            <div class="flex items-center mt-4">
                <input type="checkbox" name="activo" id="activo" value="1" 
                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded" 
                    {{ old('activo', $empleado->activo) ? 'checked' : '' }}>
                <label for="activo" class="ml-2 block text-sm text-gray-700">Activo</label>
            </div>

            <!-- Foto actual -->
            @if($empleado->foto)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Actual</label>
                    <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto actual" 
                         class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            @endif

            <!-- Nueva foto -->
            <div class="mt-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">
                    {{ $empleado->foto ? 'Cambiar Foto' : 'Foto' }}
                </label>
                <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if($empleado->foto)
                    <p class="mt-1 text-xs text-gray-500">Deja vacío si no deseas cambiar la foto actual</p>
                @endif
                @error('foto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit"
                class="inline-flex justify-center px-6 py-2 text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Actualizar
            </button>
            <a href="{{ route('empleados.show', $empleado) }}"
                class="inline-flex justify-center px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Ver Empleado
            </a>
            <a href="{{ route('empleados.index') }}"
                class="inline-flex justify-center px-6 py-2 text-indigo-700 bg-white border border-indigo-300 rounded-md shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Volver al Listado
            </a>
        </div>
    </form>
</div>
@endsection