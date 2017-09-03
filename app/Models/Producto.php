<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";

     protected $fillable = [
        'tipo_creador', 'creador_id', 'nombre', 'nombre_seo', 'descripcion', 'pais_id', 'bebida_id', 
        'clase_bebida_id', 'marca_id', 'imagen', 'ano_produccion',  'publicado', 'confirmado', 
    ];

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
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

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_producto')->withTimestamps();
    }

    public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'distribuidor_producto')->withTimestamps();
    }

    public function horecas(){
        return $this->belongsToMany('App\Models\Horeca', 'horeca_producto')->withTimestamps();
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
        if ($nombre != ""){
            return $query->where('producto.nombre', 'ILIKE', '%'.$nombre.'%');
        }
    }

    public function scopePais ($query, $pais)
    {
        if ($pais != ""){
            return $query->where('producto.pais_id', '=', $pais);
        }
    }

}
