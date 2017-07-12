<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $table = "oferta";

     protected $fillable = [
        'producto_id', 'tipo_creador', 'creador_id', 'titulo', 'descripcion', 'precio_unitario', 'precio_lote', 
        'cantidad_producto', 'cantidad_caja', 'cantidad_minima', 'envio', 'costo_envio', 'visible_importadores',
        'visible_distribuidores', 'visible_horecas', 'cantidad_visitas', 'cantidad_contactos', 'fecha', 'status',
    ];

    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }

    public function destinos_ofertas(){
    	return $this->hasMany('App\Models\Destino_Oferta');
    }
}
