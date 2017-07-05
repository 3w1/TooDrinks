<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Distribucion extends Model
{
    protected $table = "solicitud_distribucion";

    protected $fillable = [
    	'distribuidor_id', 'producto_id', 'provincia_region_id', 'status', 
    ]; 


    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }

    public function distribuidor(){
    	return $this->belongsTo('App\Models\Distribuidor');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }
}
