<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = "marca";

    protected $fillable = [
        'productor_id', 'creador_id', 'tipo_creador', 'nombre', 'nombre_seo', 'descripcion', 'pais_id', 
        'provincia_region_id', 'logo', 'website', 'reclamada', 'aprobada', 'publicada',
    ];

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_marca')->withTimestamps();
    }

    public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'distribuidor_marca')->withTimestamps();
    }

     public function productos(){
        return $this->hasMany('App\Models\Producto');
    }
}
