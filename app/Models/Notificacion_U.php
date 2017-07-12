<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_U extends Model
{
    protected $table = "notificacion_u";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'user_id', 'tipo', 'titulo', 'url', 'descripcion', 'color', 'icono', 'fecha', 'leida',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}
