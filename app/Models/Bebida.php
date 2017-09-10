<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bebida extends Model
{
    protected $table = "bebida";

    protected $fillable = [
    	'nombre', 'caracteristicas', 'imagen',
    ]; 

    public function clases_bebidas(){
    	return $this->hasMany('App\Models\Clase_Bebida');
    }

    public function productos(){
    	return $this->hasMany('App\Models\Producto');
    }

    public function demandas_productos(){
        return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function solicitudes_importacion(){
        return $this->hasMany('App\Models\Solicitud_Importacion');
    }

    public function solicitudes_distribucion(){
        return $this->hasMany('App\Models\Solicitud_Distribucion');
    }

    public function scopeNombre($query, $nombre){
        if ($nombre != ""){
            $query->where('nombre', 'ILIKE', '%'.$nombre.'%');
        }
    }
}
