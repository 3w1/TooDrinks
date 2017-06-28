<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_H extends Model
{
     protected $table = "notificacion_h";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'horeca_id', 'titulo', 'url', 'descripcion', 'color', 'icono',
    ];

    public function horeca(){
    	return $this->belongsTo('App\Models\Horeca');
    }
}
