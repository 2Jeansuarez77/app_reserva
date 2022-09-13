<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SociosPostRequest extends FormRequest
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
            'dni'           => 'required|unique:socios,dni,'.$this->get('id'),
            'nombres'       => 'required',
            'apellidos'     => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

     
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'dni'       => 'DNI',
            'nombres'   => 'Nombres',
            'apellidos' => 'Apellidos',
        ];
    }


    public function messages()
    {
        return [
            'dni.required'          => 'DNI es requerido',
            'dni.unique'            => 'Ya existe un socio con ese DNI',
            'nombres.required'      => 'Nombre(s) es requerido',
            'apellidos.required'    => 'Apellidos son requeridos',

        ];
    }
}
