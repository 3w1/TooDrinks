<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase_Bebida extends Model
{
    protected $table = "clase_bebida";

    protected $fillable = [
    	'bebida_id', 'clase', 'pais_id', 'caracteristicas',
    ]; 

    public function bebida(){
    	return $this->belongsTo('App\Models\Bebida');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

     public function productos(){
        return $this->hasMany('App\Models\Producto');
    }
}
