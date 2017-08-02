<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditoUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'plan' =>'required',
            'cantidad_creditos' =>'required',
            'precio' =>'required',
            'descripcion' =>'required',
        ];
    }
}
