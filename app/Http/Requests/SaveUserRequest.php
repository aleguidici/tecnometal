<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
            'email' => 'required',
            'tipo_usuario' => 'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar un nombre de usuario.',
            'email.required' => 'Debe ingresar el email del usuario.',
            'tipo_usuario.required'=>'Debe seleccionar un tipo de usuario.',
            'password.required'=>'Debe ingresar la contraseña del usuario.',
        ];
    }
}
