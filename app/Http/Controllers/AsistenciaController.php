<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with('empleado')->orderBy('fecha', 'desc')->get();
        return view('asistencias.index', compact('asistencias'));
    }

    public function create()
    {
        $empleados = Empleado::where('activo', true)->orderBy('nombres')->get();
        return view('asistencias.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'comentarios' => 'nullable|string|max:500',
        ]);

        // Evitar duplicados por empleado y fecha
        $existe = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withErrors(['fecha' => 'Ya existe un registro de asistencia para este empleado en la fecha indicada.'])
                ->withInput();
        }

        Asistencia::create([
            'empleado_id' => $request->empleado_id,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }

    public function show(Asistencia $asistencia)
    {
        $asistencia->load('empleado');
        return view('asistencias.show', compact('asistencia'));
    }

    public function edit(Asistencia $asistencia)
    {
        $empleados = Empleado::where('activo', true)->orderBy('nombres')->get();
        return view('asistencias.edit', compact('asistencia', 'empleados'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'comentarios' => 'nullable|string|max:500',
        ]);

        // Evitar duplicados por empleado y fecha, excepto el mismo registro actual
        $existe = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->where('id', '!=', $asistencia->id)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withErrors(['fecha' => 'Ya existe un registro de asistencia para este empleado en la fecha indicada.'])
                ->withInput();
        }

        $asistencia->update([
            'empleado_id' => $request->empleado_id,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }
}
