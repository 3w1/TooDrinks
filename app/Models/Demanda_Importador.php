<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda_Importador extends Model
{
    protected $table = "demanda_importador";

    protected $fillable = [
    	'productor_id', 'marca_id', 'pais_id', 'status', 
    ]; 


    public function marca(){
    	return $this->belongsTo('App\Models\Marca');
    }

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }
}
