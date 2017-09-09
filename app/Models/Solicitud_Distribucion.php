<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Distribucion extends Model
{
    protected $table = "solicitud_distribucion";

    protected $fillable = [
    	'distribuidor_id', 'marca_id', 'producto_id', 'provincia_region_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
    ]; 

    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }

    public function bebida(){
    	return $this->belongsTo('App\Models\Bebida');
    }

    public function distribuidor(){
    	return $this->belongsTo('App\Models\Distribuidor');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }
}
