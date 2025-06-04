<?php

use Illuminate\Support\Facades\Route;

// Controladores para Recursos Humanos
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoController;

// Controladores para Asistencias y ausencias
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
Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');

Route::resource('puestos', PuestoController::class);

Route::resource('departamentos', DepartamentoController::class);
Route::resource('documentos', DocumentoController::class);

// Módulo: Asistencias y ausencias
Route::resource('asistencias', AsistenciaController::class);
Route::resource('ausencia', AusenciasController::class);
Route::resource('permisos', PermisoController::class);
Route::resource('vacacion', VacacionController::class);
