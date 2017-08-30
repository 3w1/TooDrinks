<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admin";

    protected $fillable = [
        'rol', 'name', 'email', 'password', 'nombre', 'apellido', 'avatar', 'remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
