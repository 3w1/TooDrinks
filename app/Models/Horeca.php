<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horeca extends Model
{
    protected $table = "horeca";

    protected $fillable = [
        'user_id', 'nombre', 'nombre_seo', 'descripcion', 'direccion', 'codigo_postal', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto',
        'telefono', 'telefono_opcional', 'email', 'website', 'facebook', 'twitter', 'instagram', 'reclamada', 
        'latitud', 'longitud', 'estado_datos', 'tipo_horeca', 'saldo', 
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

    public function creditos(){
        return $this->belongsToMany('App\Models\Credito', 'horeca_credito')->withPivot('total', 'fecha_compra')->withTimestamps();
    }

    public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'importador_distribuidor')->withTimestamps();
    }

    public function productos(){
        return $this->belongsToMany('App\Models\Producto', 'horeca_producto')->withPivot('status')->withTimestamps();
    }

    public function deducciones_creditos_horecas(){
        return $this->hasMany('App\Models\Deduccion_Credito_Horeca');
    }

    public function demandas_productos(){
        return $this->hasMany('App\Models\Demanda_Producto');
    }

    public function notificaciones_h(){
        return $this->hasMany('App\Models\Notificacion_H');
    }
}
