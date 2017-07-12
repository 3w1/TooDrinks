<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_I extends Model
{
    protected $table = "notificacion_i";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'importador_id', 'tipo', 'titulo', 'url', 'descripcion', 'color', 'icono', 'fecha', 'leida',
    ];

    public function importador(){
    	return $this->belongsTo('App\Models\Importador');
    }
}
