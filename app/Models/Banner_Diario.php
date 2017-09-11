<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner_Diario extends Model
{
    protected $table = "banner_diario";

    protected $fillable = [
        'banner_id', 'pais_id', 'fecha','imagen',    ];

    public function banner(){
    	return $this->belongsTo('App\Models\Banner');
    }

    public function pais(){
    	return $this->belongsTo('App\Models\Pais');
    }
}
