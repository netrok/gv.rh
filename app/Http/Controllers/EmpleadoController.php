<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with(['puesto', 'departamento'])->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        return view('empleados.create', compact('puestos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_empleado' => 'required|unique:empleados',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'estado_civil' => 'nullable|string',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'fecha_ingreso' => 'required|date',
            'activo' => 'boolean',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Activo puede no venir, poner default
        $validated['activo'] = $request->has('activo') ? true : false;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        Empleado::create($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Empleado $empleado)
    {
        $empleado->load(['puesto', 'departamento', 'documentos', 'asistencias', 'vacaciones', 'permisos']);
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        return view('empleados.edit', compact('empleado', 'puestos', 'departamentos'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'num_empleado' => 'required|unique:empleados,num_empleado,' . $empleado->id,
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'estado_civil' => 'nullable|string',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'fecha_ingreso' => 'required|date',
            'activo' => 'boolean',
            'foto' => 'nullable|image|max:2048'
        ]);

        $validated['activo'] = $request->has('activo') ? true : false;

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Empleado $empleado)
    {
        // Eliminar foto si existe
        if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
