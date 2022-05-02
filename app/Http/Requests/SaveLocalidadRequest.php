<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveLocalidadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
        //ej: $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'codigo_postal' => 'required',
            'provincia_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar el nombre de la localidad.',
            'codigo_postal.required' => 'Debe ingresar el código postal de la localidad.',
            'provincia_id.required'=>'Debe seleccionar la provincia de la localidad.'
        ];
    }
}
