<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multinacional extends Model
{
    protected $table = "multinacional";

    protected $fillable = [
        'user_id', 'productor_id', 'nombre', 'nombre_seo', 'descripcion', 'direccion', 'codigo_postal', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto', 'telefono', 'telefono_opcional', 'email', 'website', 'facebook', 'twitter', 'instagram', 'reclamada', 'latitud', 'longitud', 'estado_datos', 'suscripcion_id', 'saldo', 'invitacion', 'fecha_invitacion',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function productor(){
        return $this->belongsTo('App\Models\Productor');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function ofertas(){
    	return $this->hasMany('App\Models\Oferta');
    }

    public function demandas_marcadas(){
        return $this->belongsToMany('App\Models\Demanda_Producto', 'multinacional_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function creditos(){
    	return $this->belongsToMany('App\Models\Credito', 'multinacional_credito')->withPivot('total', 'fecha_compra')->withTimestamps();
    }
    public function suscripcion(){
        return $this->belongsTo('App\Models\Suscripcion');
    }

    public function pagos_suscripciones(){
        return $this->belongsToMany('App\Models\Suscripcion', 'multinacional_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }

    public function deducciones_creditos_multinacionales(){
    	return $this->hasMany('App\Models\Deduccion_Credito_Multinacional');
    }

    public function notificaciones_m(){
        return $this->hasMany('App\Models\Notificacion_M');
    }
}
