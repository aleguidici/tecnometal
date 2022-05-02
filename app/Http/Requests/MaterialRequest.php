<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required',
            'unidad_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'descripcion.required' => 'Debe ingresar una Descripción para el material.'
        ];
    }
}
