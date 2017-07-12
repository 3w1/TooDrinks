<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Importacion extends Model
{
    protected $table = "solicitud_importacion";

    protected $fillable = [
    	'importador_id', 'producto_id', 'pais_id', 'status', 'fecha', 'cantidad_visitas', 'cantidad_contactos',
    ]; 


    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }

    public function importador(){
    	return $this->belongsTo('App\Models\Importador');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }
}
