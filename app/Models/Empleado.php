<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empleados';

    protected $fillable = [
        'num_empleado',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'curp',
        'rfc',
        'nss',
        'telefono',
        'email',
        'puesto_id',
        'departamento_id',
        'jefe_id',
        'fecha_ingreso',
        'activo',
        'foto'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'deleted_at' => 'datetime', // Agregado para SoftDeletes
        'activo' => 'boolean',
        'puesto_id' => 'integer',
        'departamento_id' => 'integer',
        'jefe_id' => 'integer'
    ];

    // Atributos por defecto
    protected $attributes = [
        'activo' => true,
    ];

    // Validaciones mejoradas
    public static function rules($id = null)
    {
        return [
            'num_empleado' => 'required|string|max:20|unique:empleados,num_empleado,' . $id,
            'nombres' => 'required|string|max:100|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'apellido_paterno' => 'required|string|max:50|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'apellido_materno' => 'nullable|string|max:50|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'genero' => 'required|in:M,F',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo,Union_Libre',
            'curp' => 'required|string|size:18|regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/|unique:empleados,curp,' . $id,
            'rfc' => 'required|string|size:13|regex:/^[A-Z&Ñ]{3,4}[0-9]{6}[A-V1-9][A-Z1-9][0-9A]$/|unique:empleados,rfc,' . $id,
            'nss' => 'nullable|string|size:11|regex:/^[0-9]{11}$/',
            'telefono' => 'nullable|string|max:15|regex:/^[0-9\-\+\(\)\s]+$/',
            'email' => 'required|email|max:100|unique:empleados,email,' . $id,
            'puesto_id' => 'required|integer|exists:puestos,id',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'jefe_id' => 'nullable|integer|exists:empleados,id|different:id',
            'fecha_ingreso' => 'required|date|before_or_equal:today|after_or_equal:fecha_nacimiento',
            'activo' => 'boolean',
            'foto' => 'nullable|string|max:255'
        ];
    }

    // Validaciones personalizadas adicionales
    public static function customRules($id = null)
    {
        return [
            'edad_minima' => function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->age < 18) {
                    $fail('El empleado debe ser mayor de edad (18 años).');
                }
            },
            'jefe_diferente' => function ($attribute, $value, $fail) use ($id) {
                if ($value == $id) {
                    $fail('Un empleado no puede ser jefe de sí mismo.');
                }
            }
        ];
    }

    // Scopes mejorados
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    public function scopePorDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId);
    }

    public function scopePorPuesto($query, $puestoId)
    {
        return $query->where('puesto_id', $puestoId);
    }

    public function scopePorGenero($query, $genero)
    {
        return $query->where('genero', $genero);
    }

    public function scopeConAntiguedadMayorA($query, $años)
    {
        return $query->whereDate('fecha_ingreso', '<=', now()->subYears($años));
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombres', 'like', '%' . $termino . '%')
              ->orWhere('apellido_paterno', 'like', '%' . $termino . '%')
              ->orWhere('apellido_materno', 'like', '%' . $termino . '%')
              ->orWhere('num_empleado', 'like', '%' . $termino . '%')
              ->orWhere('email', 'like', '%' . $termino . '%')
              ->orWhere('curp', 'like', '%' . $termino . '%')
              ->orWhere('rfc', 'like', '%' . $termino . '%');
        });
    }

    // Accessors mejorados
    public function getNombreCompletoAttribute()
    {
        $nombre = trim($this->nombres . ' ' . $this->apellido_paterno);
        return $this->apellido_materno ? $nombre . ' ' . $this->apellido_materno : $nombre;
    }

    public function getInicialesAttribute()
    {
        $nombres = explode(' ', trim($this->nombres));
        $iniciales = strtoupper(substr($nombres[0], 0, 1));
        $iniciales .= strtoupper(substr($this->apellido_paterno, 0, 1));
        if ($this->apellido_materno) {
            $iniciales .= strtoupper(substr($this->apellido_materno, 0, 1));
        }
        return $iniciales;
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? Carbon::parse($this->fecha_nacimiento)->age : null;
    }

    public function getAntiguedadEnDiasAttribute()
    {
        return $this->fecha_ingreso ? Carbon::parse($this->fecha_ingreso)->diffInDays(now()) : null;
    }

    public function getAntiguedadEnAñosAttribute()
    {
        return $this->fecha_ingreso ? Carbon::parse($this->fecha_ingreso)->diffInYears(now()) : null;
    }

    public function getAntiguedadTextoAttribute()
    {
        if (!$this->fecha_ingreso) return 'N/A';
        
        $fechaIngreso = Carbon::parse($this->fecha_ingreso);
        $años = $fechaIngreso->diffInYears(now());
        $meses = $fechaIngreso->diffInMonths(now()) % 12;
        $dias = $fechaIngreso->copy()->addYears($años)->addMonths($meses)->diffInDays(now());
        
        $partes = [];
        if ($años > 0) {
            $partes[] = $años . ($años == 1 ? ' año' : ' años');
        }
        if ($meses > 0) {
            $partes[] = $meses . ($meses == 1 ? ' mes' : ' meses');
        }
        if (empty($partes) && $dias > 0) {
            $partes[] = $dias . ($dias == 1 ? ' día' : ' días');
        }
        
        return !empty($partes) ? implode(' y ', $partes) : 'Hoy';
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(storage_path('app/public/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        // Generar avatar basado en iniciales como fallback
        return $this->generateAvatarUrl();
    }

    public function getEstadoTextoAttribute()
    {
        if ($this->trashed()) {
            return 'Eliminado';
        }
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    // Mutators mejorados
    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = mb_strtoupper(trim($value), 'UTF-8');
    }

    public function setApellidoPaternoAttribute($value)
    {
        $this->attributes['apellido_paterno'] = mb_strtoupper(trim($value), 'UTF-8');
    }

    public function setApellidoMaternoAttribute($value)
    {
        $this->attributes['apellido_materno'] = $value ? mb_strtoupper(trim($value), 'UTF-8') : null;
    }

    public function setCurpAttribute($value)
    {
        $this->attributes['curp'] = strtoupper(trim($value));
    }

    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = strtoupper(trim($value));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    public function setTelefonoAttribute($value)
    {
        // Limpiar formato del teléfono
        $this->attributes['telefono'] = $value ? preg_replace('/[^0-9]/', '', $value) : null;
    }

    // Relaciones
    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }

    public function subordinados()
    {
        return $this->hasMany(Empleado::class, 'jefe_id');
    }

    public function subordinadosActivos()
    {
        return $this->hasMany(Empleado::class, 'jefe_id')->where('activo', true);
    }

    // Métodos útiles mejorados
    public function esJefe()
    {
        return $this->subordinados()->exists();
    }

    public function tieneJefe()
    {
        return !is_null($this->jefe_id);
    }

    public function activar()
    {
        return $this->update(['activo' => true]);
    }

    public function desactivar()
    {
        return $this->update(['activo' => false]);
    }

    public function puedeSerEliminado()
    {
        return !$this->esJefe() && !$this->activo;
    }

    public function esAdultoMayor()
    {
        return $this->edad >= 60;
    }

    public function tieneAntiguedadMayorA($años)
    {
        return $this->antiguedad_en_años >= $años;
    }

    // Método para generar avatar por defecto
    private function generateAvatarUrl()
    {
        $iniciales = $this->iniciales;
        $colores = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FECA57', '#FF9FF3', '#54A0FF'];
        $color = $colores[crc32($iniciales) % count($colores)];
        
        // Aquí podrías integrar con un servicio como UI Avatars o similar
        return "https://ui-avatars.com/api/?name={$iniciales}&background=" . substr($color, 1) . "&color=fff&size=200";
    }

    // Método para obtener el organigrama hacia arriba
    public function getJerarquiaHaciaArriba()
    {
        $jerarquia = collect([$this]);
        $empleado = $this;
        
        while ($empleado->jefe) {
            $empleado = $empleado->jefe;
            $jerarquia->prepend($empleado);
        }
        
        return $jerarquia;
    }

    // Método para obtener todos los subordinados (incluyendo indirectos)
    public function getTodosLosSubordinados()
    {
        $subordinados = collect();
        
        foreach ($this->subordinados as $subordinado) {
            $subordinados->push($subordinado);
            $subordinados = $subordinados->merge($subordinado->getTodosLosSubordinados());
        }
        
        return $subordinados;
    }

    // Event listeners mejorados
    protected static function boot()
    {
        parent::boot();

        // Antes de crear
        static::creating(function ($empleado) {
            // Validar edad mínima
            if (Carbon::parse($empleado->fecha_nacimiento)->age < 18) {
                throw new \Exception('El empleado debe ser mayor de edad.');
            }
        });

        // Antes de actualizar
        static::updating(function ($empleado) {
            // Evitar que se asigne como jefe de sí mismo
            if ($empleado->jefe_id == $empleado->id) {
                throw new \Exception('Un empleado no puede ser jefe de sí mismo.');
            }
        });

        // Antes de eliminar
        static::deleting(function ($empleado) {
            if ($empleado->esJefe()) {
                throw new \Exception('No se puede eliminar un empleado que es jefe de otros empleados. Primero reasigne a sus subordinados.');
            }
        });

        // Después de eliminar (soft delete)
        static::deleted(function ($empleado) {
            // Reasignar subordinados al jefe del empleado eliminado
            if ($empleado->subordinados()->exists()) {
                $empleado->subordinados()->update([
                    'jefe_id' => $empleado->jefe_id
                ]);
            }
        });
    }
}