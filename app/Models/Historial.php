<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $fillable = [
        'usuario_id',     // quién hizo el cambio
        'modulo',         // módulo donde se hizo el cambio (ej: empleado, contrato, documento...)
        'registro_id',    // id del registro afectado
        'accion',         // acción realizada (creado, actualizado, eliminado)
        'descripcion',    // detalle o comentario del cambio
        'fecha',          // fecha del evento
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
