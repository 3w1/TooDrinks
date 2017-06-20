<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    protected $table = "distribuidor";

    protected $fillable = [
        'user_id', 'nombre', 'nombre_seo', 'descripcion', 'direccion', 'codigo_postal', 'pais_id', 'provincia_region_id', 'logo', 
        'persona_contacto', 'telefono', 'telefono_opcional', 'email', 'website', 'facebook', 'twitter', 'instagram', 'reclamada', 'latitud', 
        'longitud', 'estado_datos', 'tipo_suscripcion', 'saldo', 
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function productores(){
        return $this->belongsToMany('App\Models\Productor', 'productor_distribuidor')->withTimestamps();
    }

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_distribuidor')->withTimestamps();
    }

    public function marcas(){
        return $this->belongsToMany('App\Models\Marca', 'distribuidor_marca')->withTimestamps();
    }

    public function ofertas(){
    	return $this->hasMany('App\Models\Oferta');
    }

    public function demandas_productos(){
    	return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function creditos(){
    	return $this->belongsToMany('App\Models\Credito', 'importador_credito')->withPivot('total', 'fecha_compra')->withTimestamps();
    }

     public function deducciones_creditos_distribuidores(){
    	return $this->hasMany('App\Models\Deduccion_Credito_Distribuidor');
    }

    public function suscripcion(){
        return $this->belongsTo('App\Models\Suscripcion');
    }
}
