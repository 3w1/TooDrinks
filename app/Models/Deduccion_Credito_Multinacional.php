<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduccion_Credito_Multinacional extends Model
{
    protected $table = "deduccion_credito_multinacional";

    protected $fillable = [
        'multinacional_id', 'fecha', 'descripcion', 'cantidad_creditos', 'tipo_deduccion', 'accion_id',
    ];

    public function multinacional(){
    	return $this->belongsTo('App\Models\Multinacional');
    }
}
