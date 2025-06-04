<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

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

    // Relaciones

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function vacaciones()
    {
        return $this->hasMany(Vacacion::class);
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class);
    }

    /**
     * Relación jerárquica: jefe directo del empleado
     */
    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }

    /**
     * Relación inversa: empleados subordinados a este empleado
     */
    public function subordinados()
    {
        return $this->hasMany(Empleado::class, 'jefe_id');
    }
}
