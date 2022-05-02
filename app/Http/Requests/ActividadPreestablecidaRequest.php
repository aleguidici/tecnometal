<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadPreestablecidaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required',
            'descripcion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Debe ingresar el Título de la Actividad Preestablecida.',
            'descripcion.required' => 'Debe ingresar una Descripción para la Actividad Preestablecida.'
        ];
    }
}
