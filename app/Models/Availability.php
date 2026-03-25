<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['Usu_documento', 'Ava_date', 'Ava_start_time', 'Ava_end_time', 'Ava_status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
