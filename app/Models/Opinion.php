<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
     protected $table = "opinion";

    protected $fillable = [
        'tipo_creador', 'creador_id', 'producto_id', 'valoracion', 'comentario', 'fecha', 'editada', 'fecha_ultima_edicion', 'publicada',
    ];
    
    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }
}
