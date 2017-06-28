<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_D extends Model
{
    protected $table = "notificacion_d";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'distribuidor_id', 'titulo', 'url', 'descripcion', 'color', 'icono',
    ];

    public function distribuidor(){
    	return $this->belongsTo('App\Models\Distribuidor');
    }
}
