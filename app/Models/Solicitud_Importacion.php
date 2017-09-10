<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Importacion extends Model
{
    protected $table = "solicitud_importacion";

    protected $fillable = [
    	'importador_id', 'marca_id', 'bebida_id', 'pais_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
    ]; 

    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }

    public function bebida(){
    	return $this->belongsTo('App\Models\Bebida');
    }

    public function importador(){
    	return $this->belongsTo('App\Models\Importador');
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
