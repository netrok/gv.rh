<?php

use Illuminate\Support\Facades\Route;

// Controladores para Recursos Humanos
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoController;

// Controladores para Asistencias y Ausencias
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AusenciasController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\VacacionController;

/*
|--------------------------------------------------------------------------
| Rutas web
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web para la aplicación.
| Estas rutas se cargan a través del grupo de middleware "web".
|
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Módulo: Recursos Humanos
Route::resource('empleados', EmpleadoController::class);
Route::get('/empleados/{empleado}/pdf', [EmpleadoController::class, 'generarPdf'])->name('empleados.pdf');
Route::resource('puestos', PuestoController::class);
Route::resource('departamentos', DepartamentoController::class);
Route::resource('documentos', DocumentoController::class);

// Módulo: Asistencias y Ausencias
Route::resource('asistencias', AsistenciaController::class);
Route::resource('ausencia', AusenciasController::class);  // plural para consistencia
Route::resource('permisos', PermisoController::class);
Route::resource('vacacion', VacacionController::class);  // plural para consistencia
