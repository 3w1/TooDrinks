<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = "marca";

    protected $fillable = [
        'productor_id', 'creador_id', 'tipo_creador', 'nombre', 'nombre_seo', 'descripcion', 
        'pais_id', 'logo', 'website', 'reclamada', 'publicada',
    ];

    public function productor(){
    	return $this->belongsTo('App\Models\Productor');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
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

    public function scopeNombre($query, $nombre){
    	if ($nombre != ""){
    		$query->where('nombre', 'ILIKE', '%'.$nombre.'%');
    	}
    }

    public function scopeStatus($query, $status){
    	if ($status != ""){
    		$query->where('publicada', '=', $status);
    	}
    }

    public function scopePais($query, $pais){
    	if ($pais != ""){
    		$query->where('pais_id', '=', $pais);
    	}
    }
}
