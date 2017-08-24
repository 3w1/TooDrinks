<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importador extends Model
{
    protected $table = "importador";

    protected $fillable = [
        'user_id', 'nombre', 'nombre_seo', 'descripcion', 'direccion', 'codigo_postal', 'pais_id', 'provincia_region_id', 'logo', 
        'persona_contacto', 'telefono', 'telefono_opcional', 'email', 'website', 'facebook', 'twitter', 'instagram', 'reclamada', 
        'latitud', 'longitud', 'estado_datos', 'suscripcion_id', 'saldo', 'invitacion', 'fecha_invitacion',
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
        return $this->belongsToMany('App\Models\Productor', 'productor_importador')->withTimestamps();
    }

     public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'importador_distribuidor')->withTimestamps();
    }

    public function marcas(){
        return $this->belongsToMany('App\Models\Marca', 'importador_marca')->withPivot('status')->withTimestamps();
    }

    public function productos(){
        return $this->belongsToMany('App\Models\Producto', 'importador_producto')->withTimestamps();
    }

    public function ofertas(){
    	return $this->hasMany('App\Models\Oferta');
    }

    public function ofertas_marcadas(){
        return $this->belongsToMany('App\Models\Oferta', 'importador_oferta')->withPivot('fecha')->withTimestamps();
    }

    public function demandas_productos(){
        return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function demandas_marcadas(){
        return $this->belongsToMany('App\Models\Demanda_Producto', 'importador_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function demandas_importadores(){
        return $this->belongsToMany('App\Models\Demanda_Importador', 'importador_demanda_importador')->withPivot('fecha')->withTimestamps();
    }

    public function creditos(){
    	return $this->belongsToMany('App\Models\Credito', 'importador_credito')->withPivot('total', 'fecha_compra')->withTimestamps();
    }
    
    public function suscripcion(){
        return $this->belongsTo('App\Models\Suscripcion');
    }

    public function pagos_suscripciones(){
        return $this->belongsToMany('App\Models\Suscripcion', 'importador_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }

    public function deducciones_creditos_importadores(){
    	return $this->hasMany('App\Models\Deduccion_Credito_Importador');
    }

    public function notificaciones_i(){
        return $this->hasMany('App\Models\Notificacion_I');
    }
}
