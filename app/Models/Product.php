<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'prod_id';
    protected $fillable = ['prod_nombre', 'prod_descripcion', 'prod_categoria', 'prod_precio', 'prod_cantidad', 'prod_imagen', 'fecha_registro'];
}
