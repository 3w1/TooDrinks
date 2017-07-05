<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";

     protected $fillable = [
        'nombre', 'nombre_seo', 'descripcion', 'pais_id', 'provincia_region_id', 'clase_bebida_id', 'marca_id', 
        'imagen', 'ano_produccion', 'tipo_creador', 'creador_id', 'publicado', 'confirmado', 'bebida_id',
    ];

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function clase_bebida(){
    	return $this->belongsTo('App\Models\Clase_Bebida');
    }

    public function bebida(){
        return $this->belongsTo('App\Models\Bebida');
    }

    public function marca(){
    	return $this->belongsTo('App\Models\Marca');
    }

    public function ofertas(){
        return $this->hasMany('App\Models\Oferta');
    }

    public function demandas_productos(){
    	return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function demandas_importadores(){
    	return $this->hasMany('App\Models\Demanda_Importador');
    }

    public function demandas_distribuidores(){
    	return $this->hasMany('App\Models\Demanda_Distribuidor');
    }

    public function opiniones(){
    	return $this->hasMany('App\Models\Opinion');
    }

    public function scopeNombre ($query, $nombre)
    {
        return $query->where('nombre', 'ILIKE', '%'.$nombre.'%');
    }

}
