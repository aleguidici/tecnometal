<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'direccion' => 'required',
            'cuil' => 'required',
            'condicion_iva' => 'required',
            'ingresos_brutos' => 'required',
            'localidad_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar la Razón Social del proveedor.',
            'direccion.required' => 'Debe ingresar la Dirección Del proveedor.',
            'cuil.required'=>'Debe ingresar el C.U.I.L./C.U.I.T. del proveedor.',
            'condicion_iva.required'=>'Debe seleccionar la condición del iva del proveedor.',
            'ingresos_brutos.required'=>'Debe indicar si el proveedor tributa ingresos brutos.',
            'localidad_id.required'=>'Debe seleccionar la localidad del proveedor.'
        ];
    }
}
