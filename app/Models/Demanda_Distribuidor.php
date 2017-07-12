<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda_Distribuidor extends Model
{
    protected $table = "demanda_distribuidor";

    protected $fillable = [
    	'tipo_creador', 'creador_id', 'marca_id', 'provincia_region_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
    ]; 


    public function marca(){
    	return $this->belongsTo('App\Models\Marca');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }
}
