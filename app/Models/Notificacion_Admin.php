<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion_Admin extends Model
{
    protected $table = "notificacion_admin";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'admin_id', 'tipo', 'titulo', 'url', 'descripcion', 'color', 'icono', 'fecha', 'leida',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}
