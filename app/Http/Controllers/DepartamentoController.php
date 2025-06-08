<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Departamento::with(['jefe', 'empleados']);

        // Aplicar filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jefe_id')) {
            $query->where('jefe_id', $request->jefe_id);
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $departamentos = $query->withCount('empleados')
                              ->orderBy('nombre')
                              ->paginate(10);

        $jefes = Empleado::orderBy('nombres')->get();

        return view('departamentos.index', compact('departamentos', 'jefes'));
    }

    /**
     * Generate PDF report of departments.
     */
    public function pdf(Request $request)
    {
        $query = Departamento::with(['jefe', 'empleados']);

        // Aplicar los mismos filtros que en index si vienen por parámetros GET
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jefe_id')) {
            $query->where('jefe_id', $request->jefe_id);
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $departamentos = $query->withCount('empleados')
                              ->orderBy('nombre')
                              ->get();

        // Obtener estadísticas
        $stats = [
            'total' => $departamentos->count(),
            'activos' => $departamentos->where('activo', true)->count(),
            'inactivos' => $departamentos->where('activo', false)->count(),
            'con_jefe' => $departamentos->whereNotNull('jefe_id')->count(),
        ];

        // Información de filtros aplicados
        $filtros = [];
        if ($request->filled('search')) {
            $filtros['busqueda'] = $request->search;
        }
        if ($request->filled('jefe_id')) {
            $jefe = Empleado::find($request->jefe_id);
            $filtros['jefe'] = $jefe ? $jefe->nombres . ' ' . $jefe->apellido_paterno : 'Desconocido';
        }
        if ($request->filled('activo')) {
            $filtros['estado'] = $request->activo === '1' ? 'Activos' : 'Inactivos';
        }

        $pdf = Pdf::loadView('departamentos.pdf', compact('departamentos', 'stats', 'filtros'));
        
        $filename = 'departamentos_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jefes = Empleado::orderBy('nombres')->get();
        return view('departamentos.create', compact('jefes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:departamentos,codigo',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'jefe_id' => 'nullable|exists:empleados,id',
            'activo' => 'boolean'
        ]);

        Departamento::create($validatedData);

        return redirect()->route('departamentos.index')
                        ->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        $departamento->load(['jefe', 'empleados']);
        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        $jefes = Empleado::orderBy('nombres')->get();
        return view('departamentos.edit', compact('departamento', 'jefes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:departamentos,codigo,' . $departamento->id,
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'jefe_id' => 'nullable|exists:empleados,id',
            'activo' => 'boolean'
        ]);

        $departamento->update($validatedData);

        return redirect()->route('departamentos.index')
                        ->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        try {
            $departamento->delete();
            return redirect()->route('departamentos.index')
                            ->with('success', 'Departamento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('departamentos.index')
                            ->with('error', 'No se pudo eliminar el departamento. Puede tener empleados asignados.');
        }
    }
}