<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Deduccion_Credito_Productor extends Model
{
    protected $table = "deduccion_credito_productor";

    protected $fillable = [
        'productor_id', 'descripcion', 'cantidad_creditos', 
    ];

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }
}
