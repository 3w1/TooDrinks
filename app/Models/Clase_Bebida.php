<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase_Bebida extends Model
{
    protected $table = "clase_bebida";

    protected $fillable = [
    	'bebida_id', 'clase', 'caracteristicas',
    ]; 

    public function bebida(){
    	return $this->belongsTo('App\Models\Bebida');
    }

     public function productos(){
        return $this->hasMany('App\Models\Producto');
    }
}
