<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';

    protected $fillable = [
    	'pais',
    ]; 

    public function provincias_regiones(){
    	return $this->hasMany('App\Models\Provincia_Region');
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

    public function horecas(){
    	return $this->hasMany('App\Models\Horeca');
    }

    public function marcas(){
        return $this->hasMany('App\Models\Marca');
    }

    public function clases_bebidas(){
        return $this->hasMany('App\Models\Clase_Bebida');
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

    public function impresiones_banners(){
    	return $this->hasMany('App\Models\Impresion_Banner');
    }
}
