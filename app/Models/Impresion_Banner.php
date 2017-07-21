<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impresion_Banner extends Model
{
    protected $table = "impresion_banner";

    protected $fillable = [
        'banner_id', 'pais_id', 'tiempo_publicacion', 'fecha_inicio', 'fecha_fin', 'pago',
        'cantidad_clics', 'publicado', 
    ];

    public function banner(){
    	return $this->belongsTo('App\Models\Banner');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }
}
