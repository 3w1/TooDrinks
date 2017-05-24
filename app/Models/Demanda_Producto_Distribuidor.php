<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda_Producto_Distribuidor extends Model
{
     protected $table = "demanda_producto_distribuidor";

    protected $fillable = [
    	'producto_id', 'distribuidor_id', 'pais_id', 'provincia_region_id', 'titulo', 'descripcion', 'cantidad_minima', 'cantidad_maxima', 
    	'fecha_creacion', 'fecha_caducidad',
    ]; 

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function distribuidor(){
    	return $this->belongsTo('App\Distribuidor');
    }

    public function pais(){
    	return $this->belongsTo('App\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Provincia_Region');
    }
}