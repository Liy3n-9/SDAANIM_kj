<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'ord_id';

    protected $fillable = [
        'Usu_documento',
        'ord_estado',
        'ord_fechaCreacion',
        'ord_fechaExpiracion',
        'ord_fechaRecogida',
        'ord_total',
    ];

    protected $casts = [
        'ord_fechaCreacion' => 'datetime',
        'ord_fechaExpiracion' => 'datetime',
        'ord_fechaRecogida' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'ord_id');
    }
}
