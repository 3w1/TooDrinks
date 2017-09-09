<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = "banner";

    protected $fillable = [
        'creador_id', 'tipo_creador', 'titulo', 'descripcion', 'imagen', 'url_banner', 'aprobado',
        'correcciones', 'admin',
    ];

    public function banner(){
    	return $this->hasMany('App\Models\Impresion_Banner');
    }

    public function scopeEntidad($query, $tipo, $id){
    	if ($tipo != ""){
    		$query->where('tipo_creador', '=', $tipo)->where('creador_id', '=', $id);
    	}
    }

    public function scopeNombre($query, $nombre){
    	if ($nombre != ""){
    		$query->where('titulo', 'ILIKE', '%'.$nombre.'%');
    	}
    }

    public function scopeStatus($query, $status){
        if ($status != ""){
            $query->where('aprobado', '=', $status);
        }
    }
}
