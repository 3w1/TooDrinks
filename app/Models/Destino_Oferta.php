<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destino_Oferta extends Model
{
    protected $table = "destino_oferta";

     protected $fillable = [
    	'oferta_id', 'pais_id', 'provincia_region_id',
    ]; 
    
    public function oferta(){
        return $this->belongsTo('App\Models\Oferta');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

}
