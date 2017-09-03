<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impresion_Banner extends Model
{
    protected $table = "impresion_banner";

    protected $fillable = [
        'banner_id', 'pais_id', 'tiempo_publicacion', 'fecha_inicio', 'fecha_fin', 'precio',
        'cantidad_clics', 'pagado', 'admin',
    ];

    public function banner(){
    	return $this->belongsTo('App\Models\Banner');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function scopeEntidad($query, $tipo, $id){
        if ($tipo != ""){
            $query->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                  ->where('banner.tipo_creador', '=', $tipo)
                  ->where('banner.creador_id', '=', $id);
        }
    }

    public function scopeNombre($query, $nombre){
        if ($nombre != ""){
            $query->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                  ->where('banner.titulo', 'ILIKE', '%'.$nombre.'%');
        }
    }

    public function scopePais($query, $pais){
        if ($pais != ""){
            $query->where('pais_id', '=', $pais);
        }
    }
}
