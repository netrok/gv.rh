<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Sistema de Recursos Humanos para gestión de empleados, asistencias y vacaciones.">
    <meta property="og:title" content="Proyecto Recursos Humanos" />
    <meta property="og:description" content="Sistema de Recursos Humanos para gestión de empleados, asistencias y vacaciones." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('images/og-image.png') }}" />
    <title>@yield('title', 'Proyecto RH')</title>
    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-normal tracking-normal">

    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-700">Proyecto Recursos Humanos</h1>
            <nav>
                <ul class="flex space-x-4 text-gray-700">
                    <li><a href="{{ route('empleados.index') }}" class="hover:text-blue-800">Empleados</a></li>
                    <li><a href="{{ route('puestos.index') }}" class="hover:text-blue-800">Puestos</a></li>
                     <li><a href="{{ route('departamentos.index') }}" class="hover:text-blue-800">Departamentos</a></li>
                    <li><a href="{{ route('asistencias.index') }}" class="hover:text-blue-800">Asistencia</a></li>
                    <li><a href="{{ route('ausencia.index') }}" class="hover:text-blue-800">Ausencia</a></li>
                    <li><a href="{{ route('vacacion.index') }}" class="hover:text-blue-800">Vacaciones</a></li>
                    <li><a href="{{ route('sucursales.index') }}" class="hover:text-blue-800">Sucursales</a></li>
                    <!-- Más enlaces si los tienes -->
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <footer class="bg-white shadow p-4 mt-10 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Mi Empresa
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
