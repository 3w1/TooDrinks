<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_M extends Model
{
    protected $table = "notificacion_m";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'multinacional_id', 'tipo', 'titulo', 'url', 'descripcion', 'color', 'icono', 'fecha', 'leida',
    ];

    public function multinacional(){
    	return $this->belongsTo('App\Models\Multinacional');
    }
}
