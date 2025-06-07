<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'activo' => 'boolean',
        'puesto_id' => 'integer',
        'departamento_id' => 'integer',
        'jefe_id' => 'integer'
    ];

    // No necesitas $dates con SoftDeletes, se maneja automáticamente
    // protected $dates = ['deleted_at']; // REMOVIDO

    // Validaciones básicas
    public static function rules($id = null)
    {
        return [
            'num_empleado' => 'required|string|unique:empleados,num_empleado,' . $id,
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:M,F',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo,Union_Libre',
            'curp' => 'required|string|size:18|unique:empleados,curp,' . $id,
            'rfc' => 'required|string|size:13|unique:empleados,rfc,' . $id,
            'nss' => 'nullable|string|max:11', // Cambié size por max
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:empleados,email,' . $id,
            'puesto_id' => 'required|integer|exists:puestos,id',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'jefe_id' => 'nullable|integer|exists:empleados,id',
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'activo' => 'boolean',
            'foto' => 'nullable|string|max:255' // Agregué longitud máxima
        ];
    }

    // Atributos por defecto
    protected $attributes = [
        'activo' => true,
    ];

    // Scopes
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

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombres', 'like', '%' . $termino . '%')
              ->orWhere('apellido_paterno', 'like', '%' . $termino . '%')
              ->orWhere('apellido_materno', 'like', '%' . $termino . '%')
              ->orWhere('num_empleado', 'like', '%' . $termino . '%')
              ->orWhere('email', 'like', '%' . $termino . '%');
        });
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    public function getInicialesAttribute()
    {
        $nombres = explode(' ', $this->nombres);
        $iniciales = substr($nombres[0], 0, 1);
        $iniciales .= substr($this->apellido_paterno, 0, 1);
        if ($this->apellido_materno) {
            $iniciales .= substr($this->apellido_materno, 0, 1);
        }
        return strtoupper($iniciales);
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    public function getAntiguedadAttribute()
    {
        return $this->fecha_ingreso ? $this->fecha_ingreso->diffInYears(now()) : null;
    }

    public function getAntiguedadTextoAttribute()
    {
        if (!$this->fecha_ingreso) return 'N/A';
        
        $years = $this->fecha_ingreso->diffInYears(now());
        $months = $this->fecha_ingreso->diffInMonths(now()) % 12;
        
        $texto = '';
        if ($years > 0) {
            $texto .= $years . ($years == 1 ? ' año' : ' años');
        }
        if ($months > 0) {
            if ($texto) $texto .= ' y ';
            $texto .= $months . ($months == 1 ? ' mes' : ' meses');
        }
        
        return $texto ?: 'Menos de un mes';
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png'); // Imagen por defecto
    }

    // Mutators
    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = strtoupper(trim($value));
    }

    public function setApellidoPaternoAttribute($value)
    {
        $this->attributes['apellido_paterno'] = strtoupper(trim($value));
    }

    public function setApellidoMaternoAttribute($value)
    {
        $this->attributes['apellido_materno'] = $value ? strtoupper(trim($value)) : null;
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

    // Métodos útiles
    public function esJefe()
    {
        return $this->subordinados()->count() > 0;
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
        return !$this->esJefe();
    }

    // Event listeners
    protected static function boot()
    {
        parent::boot();

        // Antes de eliminar, verificar que no sea jefe
        static::deleting(function ($empleado) {
            if ($empleado->esJefe()) {
                throw new \Exception('No se puede eliminar un empleado que es jefe de otros empleados.');
            }
        });
    }
}