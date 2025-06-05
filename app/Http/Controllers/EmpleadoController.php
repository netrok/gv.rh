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
        $empleados = Empleado::with(['puesto', 'departamento', 'jefe'])->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $jefes = Empleado::where('activo', true)->get();
        return view('empleados.create', compact('puestos', 'departamentos', 'jefes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_empleado' => 'required|unique:empleados,num_empleado',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string|in:M,F,O',
            'estado_civil' => 'nullable|string|in:soltero,casado,divorciado,viudo',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'jefe_id' => 'nullable|exists:empleados,id',
            'fecha_ingreso' => 'required|date',
            'activo' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['activo'] = $request->has('activo');
        $validated['foto'] = $this->manejarFoto($request);

        Empleado::create($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Empleado $empleado)
    {
        $empleado->load(['puesto', 'departamento', 'jefe', 'documentos', 'asistencias', 'vacaciones', 'permisos']);
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $jefes = Empleado::where('id', '!=', $empleado->id)->where('activo', true)->get();
        return view('empleados.edit', compact('empleado', 'puestos', 'departamentos', 'jefes'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'num_empleado' => 'required|unique:empleados,num_empleado,' . $empleado->id,
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string|in:M,F,O',
            'estado_civil' => 'nullable|string|in:soltero,casado,divorciado,viudo',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'jefe_id' => 'nullable|exists:empleados,id|not_in:' . $empleado->id,
            'fecha_ingreso' => 'required|date',
            'activo' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['activo'] = $request->has('activo');
        $validated['foto'] = $this->manejarFoto($request, $empleado);

        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Empleado $empleado)
    {
        if (Empleado::where('jefe_id', $empleado->id)->exists()) {
            return redirect()->route('empleados.index')->with('error', 'No se puede eliminar al empleado porque es jefe de otros empleados.');
        }

        if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }

    private function manejarFoto(Request $request, Empleado $empleado = null)
    {
        if ($request->hasFile('foto')) {
            if ($empleado && $empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            $file = $request->file('foto');
            $filename = uniqid() . '.' . $file->extension();
            return $file->storeAs('fotos', $filename, 'public');
        }

        return $empleado ? $empleado->foto : null;
    }
}
