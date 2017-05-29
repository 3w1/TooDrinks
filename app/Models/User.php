<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
        'name', 'email', 'password', 'nombre', 'apellido', 'direccion', 'telefono', 'telefono_opcional', 
        'codigo_postal', 'pais_id', 'provincia_region_id', 'avatar', 'estado_datos', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }

    public function provincia_region(){
    	return $this->belongsTo('App\Models\Provincia_Region');
    }

    public function productores(){
        return $this->hasMany('App\Models\Productor');
    }

    public function importadores(){
    	return $this->hasMany('App\Models\Importador');
    }

    public function distribuidores(){
    	return $this->hasMany('App\Models\Distribuidor');
    }

    public function horecas(){
    	return $this->hasMany('App\Models\Horeca');
    }

    public function opiniones(){
        return $this->hasMany('App\Models\Opinion');
    }
}
