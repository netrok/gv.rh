<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ausencias extends Model
{
    protected $fillable = [
        'empleado_id',
        'fecha_inicio',
        'fecha_fin',
        'motivo',
        'comentarios',
        'estatus', // pendiente, aprobada, rechazada, etc.
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
