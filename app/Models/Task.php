<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $primaryKey = 'Tar_id';
    protected $fillable = [
        'Usu_documento', 'Tar_titulo', 'Tar_descripcion',
        'Tar_fecha_asignacion', 'Tar_fecha_limite',
        'Tar_estado', 'Tar_comentario', 'Tar_hora', 'Tar_base', 'soli_id'
    ];

    // Cast de fechas a Carbon
    protected $casts = [
        'Tar_fecha_asignacion' => 'datetime',
        'Tar_fecha_limite' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}