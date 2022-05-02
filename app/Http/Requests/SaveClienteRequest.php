<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClienteRequest extends FormRequest
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
            'direccion' => 'required',
            'cuil' => 'required',
            'condicion_iva' => 'required',
            'localidad_id' => 'required',
            'ingresos_brutos' => 'required',
            'tipo_persona_id' => '',
            'contactosTable' => ''
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar la Razón Social del cliente.',
            'direccion.required' => 'Debe ingresar la dirección del cliente.',
            'cuil.required'=>'Debe ingresar el C.U.I.L./C.U.I.T. del cliente.',
            'condicion_iva.required'=>'Debe seleccionar la condición del iva del cliente.',
            'ingresos_brutos.required'=>'Debe indicar si el cliente tributa ingresos brutos.',
            'localidad_id.required'=>'Debe seleccionar la localidad del cliente.'
        ];
    }
}
