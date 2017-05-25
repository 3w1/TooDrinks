<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bebida extends Model
{
    protected $table = "bebida";

    protected $fillable = [
    	'nombre', 'caracteristicas',
    ]; 

    public function clases_bebidas(){
    	return $this->belongsTo('App\Clase_Bebida');
    }
}
