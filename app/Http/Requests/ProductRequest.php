<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
          'name'=>'required',
          'location'=>'required|regex:/^[A-z][0-9][E,e,D,D]$/',
        ];
    }

    public function messages()
    {
      return [
        'name.required'=>'Preencha o nome do produto.',
        'location.required'=>'Preecha a localização do produto.',
        'location.regex'=>'Formato da localização inválido. Tente no formaro A1E [Corredor A-Z, prateleira 0-9, lado E ou D].'
      ];
    }
}
