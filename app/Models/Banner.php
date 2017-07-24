<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = "banner";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'titulo', 'descripcion', 'imagen', 'url_banner', 'aprobado', 'correcciones',
    ];

    public function banner(){
    	return $this->hasMany('App\Models\Impresion_Banner');
    }
}
