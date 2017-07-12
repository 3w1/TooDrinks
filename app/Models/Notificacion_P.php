<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_P extends Model
{
    protected $table = "notificacion_p";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'productor_id', 'tipo', 'titulo', 'url', 'descripcion', 'color', 'icono', 'fehca', 'leida',
    ];

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }
}
