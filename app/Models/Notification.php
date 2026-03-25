<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'Noto_id';
    protected $fillable = ['Usu_documento', 'Noti_mensaje', 'Noti_fecha', 'Noti_link', 'read_at'];
}
