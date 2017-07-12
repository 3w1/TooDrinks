<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduccion_Credito_Distribuidor extends Model
{
    protected $table = "deduccion_credito_distribuidor";

    protected $fillable = [
        'distribuidor_id', 'fecha', 'descripcion', 'cantidad_creditos', 
    ];

    public function distribuidor(){
    	return $this->belongsTo('App\Models\Distribuidor');
    }
}
