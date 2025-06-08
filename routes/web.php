<?php

use App\Http\Controllers\SucursalController;
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

// Rutas específicas que deben ir ANTES de los resources
Route::get('/empleados/{empleado}/pdf', [EmpleadoController::class, 'generarPdf'])->name('empleados.pdf');
Route::get('/departamentos/pdf', [DepartamentoController::class, 'pdf'])->name('departamentos.pdf');

// Módulo: Recursos Humanos
Route::resource('empleados', EmpleadoController::class);
Route::resource('puestos', PuestoController::class);
Route::resource('departamentos', DepartamentoController::class);
Route::resource('documentos', DocumentoController::class);
Route::resource('sucursales', SucursalController::class);

// Módulo: Asistencias y Ausencias
Route::resource('asistencias', AsistenciaController::class);
Route::resource('ausencia', AusenciasController::class);  // Corregido: era 'ausencia'
Route::resource('permisos', PermisoController::class);
Route::resource('vacacion', VacacionController::class);  // Corregido: era 'vacacion'