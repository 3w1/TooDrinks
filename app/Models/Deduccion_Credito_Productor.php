<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Deduccion_Credito_Productor extends Model
{
    protected $table = "deduccion_credito_productor";

    protected $fillable = [
        'productor_id', 'fecha', 'descripcion', 'cantidad_creditos', 'tipo_deduccion', 'accion_id', 
    ];

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }
}
