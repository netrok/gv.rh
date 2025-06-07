<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Empleado::with(['puesto', 'departamento', 'jefe']);

        // Filtro por búsqueda de nombre
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('num_empleado', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por departamento
        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->get('departamento_id'));
        }

        // Filtro por puesto
        if ($request->filled('puesto_id')) {
            $query->where('puesto_id', $request->get('puesto_id'));
        }

        // Filtro por estado activo/inactivo
        if ($request->has('activo') && $request->get('activo') !== '') {
            $query->where('activo', $request->get('activo'));
        }

        // Ordenar por número de empleado
        $query->orderBy('num_empleado');

        // Paginación
        $empleados = $query->paginate(15)->withQueryString();

        // Obtener datos para los selectores de filtros
        $departamentos = Departamento::orderBy('nombre')->get();
        $puestos = Puesto::orderBy('nombre')->get();

        return view('empleados.index', compact('empleados', 'departamentos', 'puestos'));
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
        // DEBUG: Ver datos originales
        \Log::info('Datos originales:', $request->all());

        // Transformar los datos antes de validar
        $data = $request->all();

        // Transformar género
        $generoMap = [
            'Masculino' => 'M',
            'Femenino' => 'F',
            'masculino' => 'M',
            'femenino' => 'F'
        ];

        if (isset($data['genero']) && isset($generoMap[$data['genero']])) {
            $data['genero'] = $generoMap[$data['genero']];
        }

        // Transformar estado civil
        $estadoCivilMap = [
            'S' => 'Soltero',
            'C' => 'Casado',
            'D' => 'Divorciado',
            'V' => 'Viudo',
            'UL' => 'Union_Libre',
            'Soltero' => 'Soltero',
            'Casado' => 'Casado',
            'Divorciado' => 'Divorciado',
            'Viudo' => 'Viudo',
            'Union_Libre' => 'Union_Libre'
        ];

        if (isset($data['estado_civil']) && isset($estadoCivilMap[$data['estado_civil']])) {
            $data['estado_civil'] = $estadoCivilMap[$data['estado_civil']];
        }

        // Transformar checkbox activo
        $data['activo'] = isset($data['activo']) && ($data['activo'] === 'on' || $data['activo'] == '1') ? true : false;

        // DEBUG: Ver datos transformados
        \Log::info('Datos transformados:', $data);

        // Validar con las reglas correctas
        $validator = Validator::make($data, [
            'num_empleado' => 'required|unique:empleados,num_empleado',
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:M,F',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo,Union_Libre',
            'curp' => 'required|string|size:18|unique:empleados,curp',
            'rfc' => 'required|string|size:13|unique:empleados,rfc',
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:empleados,email',
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'jefe_id' => 'nullable|exists:empleados,id',
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'activo' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            \Log::error('Errores de validación:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Errores de validación: ' . implode(', ', $validator->errors()->all()));
        }

        try {
            // Manejar la foto antes de crear el empleado
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->manejarFoto($request);
                \Log::info('Foto manejada:', ['foto' => $data['foto']]);
            } else {
                unset($data['foto']); // Remover si no hay archivo
            }

            \Log::info('Datos finales para crear:', $data);

            $empleado = Empleado::create($data);

            \Log::info('Empleado creado exitosamente:', ['id' => $empleado->id]);

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear empleado:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el empleado: ' . $e->getMessage());
        }
    }

    public function show(Empleado $empleado)
    {
        $empleado->load(['puesto', 'departamento', 'jefe']);
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
        // Transformar los datos antes de validar
        $data = $request->all();

        // Transformar género
        $generoMap = [
            'Masculino' => 'M',
            'Femenino' => 'F',
            'masculino' => 'M',
            'femenino' => 'F'
        ];

        if (isset($data['genero']) && isset($generoMap[$data['genero']])) {
            $data['genero'] = $generoMap[$data['genero']];
        }

        // Transformar estado civil
        $estadoCivilMap = [
            'S' => 'Soltero',
            'C' => 'Casado',
            'D' => 'Divorciado',
            'V' => 'Viudo',
            'UL' => 'Union_Libre',
            'Soltero' => 'Soltero',
            'Casado' => 'Casado',
            'Divorciado' => 'Divorciado',
            'Viudo' => 'Viudo',
            'Union_Libre' => 'Union_Libre'
        ];

        if (isset($data['estado_civil']) && isset($estadoCivilMap[$data['estado_civil']])) {
            $data['estado_civil'] = $estadoCivilMap[$data['estado_civil']];
        }

        // Transformar checkbox activo
        $data['activo'] = isset($data['activo']) && ($data['activo'] === 'on' || $data['activo'] == '1') ? true : false;

        $validator = Validator::make($data, [
            'num_empleado' => 'required|unique:empleados,num_empleado,' . $empleado->id,
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:M,F',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo,Union_Libre',
            'curp' => 'required|string|size:18|unique:empleados,curp,' . $empleado->id,
            'rfc' => 'required|string|size:13|unique:empleados,rfc,' . $empleado->id,
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:empleados,email,' . $empleado->id,
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'jefe_id' => 'nullable|exists:empleados,id|not_in:' . $empleado->id,
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'activo' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario.');
        }

        try {
            // Manejar la foto
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->manejarFoto($request, $empleado);
            } else {
                $data['foto'] = $empleado->foto; // Mantener la foto existente
            }

            $empleado->update($data);
            return redirect()->route('empleados.index')
                ->with('success', 'Empleado actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            // Verificar si el empleado es jefe de otros
            if (Empleado::where('jefe_id', $empleado->id)->exists()) {
                return redirect()->route('empleados.index')
                    ->with('error', 'No se puede eliminar al empleado porque es jefe de otros empleados.');
            }

            // Eliminar foto si existe
            if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            $empleado->delete();

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('empleados.index')
                ->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    private function manejarFoto(Request $request, Empleado $empleado = null)
    {
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($empleado && $empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            return $file->storeAs('fotos_empleados', $filename, 'public');
        }

        return $empleado ? $empleado->foto : null;
    }

    public function generarPdf(Empleado $empleado)
    {
        // Cargar las relaciones necesarias
        $empleado->load(['puesto', 'departamento', 'jefe', 'subordinados.puesto']);

        // Datos adicionales para el PDF
        $data = [
            'empleado' => $empleado,
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'titulo' => 'Reporte de Empleado - ' . $empleado->nombres . ' ' . $empleado->apellido_paterno
        ];

        // Generar el PDF con configuraciones específicas para imágenes
        $pdf = Pdf::loadView('empleados.pdf', $data);

        // Configurar el PDF
        $pdf->setPaper('A4', 'portrait');

        // Configuraciones adicionales para imágenes
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial'
        ]);

        // Nombre del archivo
        $nombreArchivo = 'empleado_' . $empleado->num_empleado . '_' . date('Y-m-d') . '.pdf';

        // Retornar el PDF para descarga
        return $pdf->download($nombreArchivo);
    }
}