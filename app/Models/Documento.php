<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'empleado_id',
        'nombre',
        'archivo',
        'tipo',
        'fecha_vencimiento',
    ];

    /**
     * Relación con el empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
