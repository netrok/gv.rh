<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

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
        $puestos = Puesto::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();
        $jefes = Empleado::where('activo', true)
            ->select('id', 'nombres', 'apellido_paterno', 'apellido_materno')
            ->orderBy('nombres')
            ->get();
        
        return view('empleados.create', compact('puestos', 'departamentos', 'jefes'));
    }

    public function store(Request $request)
    {
        try {
            // Transformar y validar datos
            $data = $this->transformarDatos($request);
            $validator = $this->validarDatos($data);

            if ($validator->fails()) {
                Log::warning('Errores de validación en store:', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Por favor corrige los errores en el formulario.');
            }

            // Manejar la foto antes de crear el empleado
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->manejarFoto($request);
            }

            $empleado = Empleado::create($data);

            Log::info('Empleado creado exitosamente:', ['id' => $empleado->id, 'num_empleado' => $empleado->num_empleado]);

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado creado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al crear empleado:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el empleado. Por favor intenta nuevamente.');
        }
    }

    public function show(Empleado $empleado)
    {
        $empleado->load(['puesto', 'departamento', 'jefe', 'subordinados']);
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $puestos = Puesto::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();
        $jefes = Empleado::where('id', '!=', $empleado->id)
            ->where('activo', true)
            ->select('id', 'nombres', 'apellido_paterno', 'apellido_materno')
            ->orderBy('nombres')
            ->get();
        
        return view('empleados.edit', compact('empleado', 'puestos', 'departamentos', 'jefes'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        try {
            // Transformar y validar datos
            $data = $this->transformarDatos($request);
            $validator = $this->validarDatos($data, $empleado->id);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Por favor corrige los errores en el formulario.');
            }

            // Manejar la foto
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->manejarFoto($request, $empleado);
            } else {
                // Mantener la foto existente si no se sube una nueva
                unset($data['foto']);
            }

            $empleado->update($data);

            Log::info('Empleado actualizado exitosamente:', ['id' => $empleado->id]);

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar empleado:', [
                'message' => $e->getMessage(),
                'empleado_id' => $empleado->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el empleado. Por favor intenta nuevamente.');
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            // Verificar si el empleado es jefe de otros
            $subordinados = Empleado::where('jefe_id', $empleado->id)->count();
            if ($subordinados > 0) {
                return redirect()->route('empleados.index')
                    ->with('error', "No se puede eliminar al empleado porque es jefe de {$subordinados} empleado(s).");
            }

            // Eliminar foto si existe
            if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            $nombreEmpleado = $empleado->nombres . ' ' . $empleado->apellido_paterno;
            $empleado->delete();

            Log::info('Empleado eliminado:', ['nombre' => $nombreEmpleado]);

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado eliminado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar empleado:', [
                'message' => $e->getMessage(),
                'empleado_id' => $empleado->id
            ]);

            return redirect()->route('empleados.index')
                ->with('error', 'Error al eliminar el empleado. Por favor intenta nuevamente.');
        }
    }

    public function generarPdf(Empleado $empleado)
    {
        try {
            // Cargar las relaciones necesarias
            $empleado->load(['puesto', 'departamento', 'jefe', 'subordinados.puesto']);

            // Datos para el PDF
            $data = [
                'empleado' => $empleado,
                'fecha_generacion' => now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Empleado - ' . $empleado->nombres . ' ' . $empleado->apellido_paterno
            ];

            // Generar el PDF con configuraciones específicas
            $pdf = Pdf::loadView('empleados.pdf', $data);

            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
            ]);

            // Nombre del archivo
            $nombreArchivo = 'empleado_' . $empleado->num_empleado . '_' . now()->format('Y-m-d') . '.pdf';

            Log::info('PDF generado para empleado:', ['empleado_id' => $empleado->id, 'archivo' => $nombreArchivo]);

            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {
            Log::error('Error al generar PDF:', [
                'message' => $e->getMessage(),
                'empleado_id' => $empleado->id
            ]);

            return redirect()->back()
                ->with('error', 'Error al generar el PDF. Por favor intenta nuevamente.');
        }
    }

    /**
     * Transformar los datos del request antes de la validación
     */
    private function transformarDatos(Request $request): array
    {
        $data = $request->all();

        // Transformar género
        $generoMap = [
            'Masculino' => 'M',
            'Femenino' => 'F',
            'masculino' => 'M',
            'femenino' => 'F'
        ];

        if (isset($data['genero']) && array_key_exists($data['genero'], $generoMap)) {
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

        if (isset($data['estado_civil']) && array_key_exists($data['estado_civil'], $estadoCivilMap)) {
            $data['estado_civil'] = $estadoCivilMap[$data['estado_civil']];
        }

        // Transformar checkbox activo
        $data['activo'] = isset($data['activo']) && in_array($data['activo'], ['on', '1', 1, true], true);

        // Limpiar strings
        $stringFields = ['nombres', 'apellido_paterno', 'apellido_materno', 'curp', 'rfc', 'nss', 'telefono'];
        foreach ($stringFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = trim($data[$field]);
                if ($field === 'curp' || $field === 'rfc') {
                    $data[$field] = strtoupper($data[$field]);
                }
            }
        }

        return $data;
    }

    /**
     * Validar los datos del empleado
     */
    private function validarDatos(array $data, ?int $empleadoId = null): \Illuminate\Validation\Validator
    {
        $uniqueRule = $empleadoId ? ",{$empleadoId}" : '';

        $rules = [
            'num_empleado' => 'required|string|max:20|unique:empleados,num_empleado' . $uniqueRule,
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'genero' => 'required|in:M,F',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo,Union_Libre',
            'curp' => 'required|string|size:18|unique:empleados,curp' . $uniqueRule,
            'rfc' => 'required|string|size:13|unique:empleados,rfc' . $uniqueRule,
            'nss' => 'nullable|string|max:11',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:empleados,email' . $uniqueRule,
            'puesto_id' => 'required|exists:puestos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'jefe_id' => 'nullable|exists:empleados,id' . ($empleadoId ? "|not_in:{$empleadoId}" : ''),
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'activo' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'num_empleado.unique' => 'Este número de empleado ya está en uso.',
            'curp.unique' => 'Esta CURP ya está registrada.',
            'rfc.unique' => 'Este RFC ya está registrado.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nacimiento.after' => 'La fecha de nacimiento no puede ser anterior a 1900.',
            'fecha_ingreso.before_or_equal' => 'La fecha de ingreso no puede ser futura.',
            'jefe_id.not_in' => 'Un empleado no puede ser jefe de sí mismo.',
            'foto.max' => 'La foto no debe superar los 2MB.',
            'foto.mimes' => 'La foto debe ser un archivo JPG, JPEG, PNG o WebP.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Manejar la subida y almacenamiento de fotos
     */
    private function manejarFoto(Request $request, ?Empleado $empleado = null): ?string
    {
        if (!$request->hasFile('foto')) {
            return null;
        }

        try {
            $file = $request->file('foto');
            
            // Validar que el archivo sea válido
            if (!$file->isValid()) {
                throw new \Exception('Archivo de foto no válido');
            }

            // Eliminar foto anterior si existe
            if ($empleado && $empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            // Generar nombre único para el archivo
            $extension = $file->getClientOriginalExtension();
            $filename = 'empleado_' . time() . '_' . Str::random(10) . '.' . $extension;
            
            // Almacenar el archivo
            $path = $file->storeAs('fotos_empleados', $filename, 'public');
            
            Log::info('Foto almacenada exitosamente:', ['path' => $path]);
            
            return $path;

        } catch (\Exception $e) {
            Log::error('Error al manejar foto:', ['message' => $e->getMessage()]);
            throw new \Exception('Error al procesar la foto: ' . $e->getMessage());
        }
    }
}