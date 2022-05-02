<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManoObraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'descripcion' => 'required',
            'duracion' => '',
            'tipo_mano_obra_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar el Nombre de la Mano de Obra.',
            'descripcion.required' => 'Debe ingresar una Descripción para la Mano de Obra.'
        ];
    }
}
