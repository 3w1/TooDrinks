<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia_Region extends Model
{
    protected $table = 'provincia_region';

    protected $fillable = [
    	'provincia', 'pais_id',
    ]; 

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function users(){
    	return $this->hasMany('App\Models\User');
    }

    public function productores(){
    	return $this->hasMany('App\Models\Productor');
    }

    public function importadores(){
    	return $this->hasMany('App\Models\Importador');
    }

    public function distribuidores(){
    	return $this->hasMany('App\Models\Distribuidor');
    }

    public function horeca(){
    	return $this->hasMany('App\Models\Horeca');
    }

    public function marcas(){
        return $this->hasMany('App\Models\Marca');
    }

    public function productos(){
        return $this->hasMany('App\Models\Producto');
    }

    public function destinos_ofertas(){
        return $this->hasMany('App\Models\Destino_Oferta');
    }

    public function demandas_productos(){
        return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function demandas_importadores(){
        return $this->hasMany('App\Models\Demanda_Importador');
    }

    public function demandas_distribuidores(){
        return $this->hasMany('App\Models\Demanda_Distribuidor');
    }
}
