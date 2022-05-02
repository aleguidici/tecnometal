<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vencimiento' => 'required',
            'referencia' => '',
            'obra' => '',
            'observaciones' => 'required',
            'persona_id' => 'required',
            'contacto_id' => '',
            'user_id' => ''
        ];
    }

    public function messages()
    {
        return [
            'vencimiento.required' => 'Debe ingresar una Descripción para el material.',
            'observaciones.required' => 'Debe ingresar una Descripción para el material.',
            'persona_id.required' => 'Debe ingresar una Descripción para el material.',
        ];
    }
}
