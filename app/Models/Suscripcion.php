<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $table = "suscripcion";

    protected $fillable = ['suscripcion', 'descripcion', 'precio', 'creditos_disponibles']; 

    public function productores(){
    	return $this->hasMany('App\Models\Productor');
    }

     public function importadores(){
    	return $this->hasMany('App\Models\Importador');
    }

    public function distribuidores(){
    	return $this->hasMany('App\Models\Distribuidor');
    }

    public function pagos_suscripciones_productores(){
        return $this->belongsToMany('App\Models\Productor', 'productor_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }

    public function pagos_suscripciones_importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }

    public function pagos_suscripciones_distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'distribuidor_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }
}
