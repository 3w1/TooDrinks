<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduccion_Credito_Horeca extends Model
{
    protected $table = "deduccion_credito_horeca";

    protected $fillable = [
        'horeca_id', 'fecha', 'descripcion', 'cantidad_creditos', 'tipo_deduccion', 'accion_id',
    ];

    public function horeca(){
    	return $this->belongsTo('App\Models\Horeca');
    }
}
