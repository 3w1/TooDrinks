<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda_Importador extends Model
{
    protected $table = "demanda_importador";

    protected $fillable = [
    	'productor_id', 'marca_id', 'pais_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
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

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_demanda_importador')->withPivot('fecha')->withTimestamps();
    }

    public function scopeMarca($query, $marca){
        if ($marca != ""){
            $query->where('marca_id', '=', $marca);
        }
    }

    public function scopePais($query, $pais){
        if ($pais != ""){
            $query->where('pais_id', '=', $pais);
        }
    }
}
