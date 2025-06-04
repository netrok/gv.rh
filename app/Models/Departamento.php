<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'activo',
        'jefe_id',
    ];

    // Relaciones
    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function puestos()
    {
        return $this->hasMany(Puesto::class);
    }

    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Mutators
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
}
