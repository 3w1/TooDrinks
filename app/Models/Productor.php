<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    protected $table = "productor";

    protected $fillable = [
        'user_id', 'nombre', 'nombre_seo', 'descripcion', 'direccion', 'codigo_postal', 'pais_id', 'provincia_region_id', 'logo', 
        'persona_contacto', 'telefono', 'telefono_opcional', 'email', 'website', 'facebook', 'twitter', 'instagram',
        'reclamada', 'latitud', 'longitud', 'estado_datos', 'suscripcion_id', 'saldo', 'invitacion', 'fecha_invitacion',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function paises_importaciones(){
        return $this->belongsToMany('App\Models\Pais', 'productor_pais')->withTimestamps();
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'productor_importador')->withTimestamps();
    }

    public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'productor_distribuidor')->withTimestamps();
    }

    public function marcas(){
        return $this->hasMany('App\Models\Marca');
    }

    public function demandas_importadores(){
        return $this->hasMany('App\Models\Demanda_Importador');
    }

    public function demandas_productos(){
        return $this->belongsToMany('App\Models\Demanda_Producto', 'productor_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function creditos(){
    	return $this->belongsToMany('App\Models\Credito', 'productor_credito')->withPivot('total', 'fecha_compra')->withTimestamps();
    }

    public function suscripcion(){
        return $this->belongsTo('App\Models\Suscripcion');
    }

    public function pagos_suscripciones(){
        return $this->belongsToMany('App\Models\Suscripcion', 'productor_suscripcion')->withPivot('pago', 'fecha_compra')->withTimestamps();
    }

    public function deducciones_creditos_productores(){
        return $this->hasMany('App\Models\Deduccion_Credito_Productor');
    }

    public function notificaciones_p(){
        return $this->hasMany('App\Models\Notificacion_P');
    }
}
