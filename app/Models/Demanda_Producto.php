<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda_Producto extends Model
{
    protected $table = "demanda_producto";

    protected $fillable = [
    	'producto_id', 'bebida_id', 'tipo_creador', 'creador_id', 'pais_id', 'titulo', 'descripcion', 'cantidad_minima', 'cantidad_maxima',
        'fecha_creacion', 'status', 'cantidad_visitas', 'cantidad_contactos',
    ]; 

    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }

    public function bebida(){
        return $this->belongsTo('App\Models\Bebida');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function productores(){
        return $this->belongsToMany('App\Models\Productor', 'productor_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function importadores(){
        return $this->belongsToMany('App\Models\Importador', 'importador_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function distribuidores(){
        return $this->belongsToMany('App\Models\Distribuidor', 'distribuidor_demanda_producto')->withPivot('fecha')->withTimestamps();
    }

    public function scopeProducto($query, $producto){
        if ($producto != ""){
            $query->where('demanda_producto.producto_id', '=', $producto);
        }
    }

}
