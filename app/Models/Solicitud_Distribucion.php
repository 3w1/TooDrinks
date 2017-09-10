<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Distribucion extends Model
{
    protected $table = "solicitud_distribucion";

    protected $fillable = [
    	'distribuidor_id', 'marca_id', 'bebida_id', 'pais_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
    ]; 

    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }

    public function bebida(){
    	return $this->belongsTo('App\Models\Bebida');
    }

    public function distribuidor(){
    	return $this->belongsTo('App\Models\Distribuidor');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

     public function scopeTipo($query, $tipo){
        if ($tipo != ""){
            if ($tipo == 'M'){
                $query->where('marca_id', '<>', null);
            }else{
                $query->where('bebida_id', '<>', null);
            }
        }
    }
}
