<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditoCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'plan' =>'required|unique:credito',
            'cantidad_creditos' =>'required',
            'precio' =>'required',
            'descripcion' =>'required',
        ];
    }
}
