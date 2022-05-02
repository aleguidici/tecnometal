<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGastoPreestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
        //ej: $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'descripcion' => 'required',
            'valor' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'descripcion.required' => 'Debe ingresar la descripción del impuesto.',
            'valor.required' => 'Debe ingresar el valor del impuesto.',
        ];
    }
}
