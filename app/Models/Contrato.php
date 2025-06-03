<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'empleado_id',
        'tipo_contrato',
        'fecha_inicio',
        'fecha_fin',
        'salario',
        'estatus',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
