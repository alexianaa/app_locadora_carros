<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModeloRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'required|unique:modelos|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            'marca_id' => 'required|exists:marcas,id',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'required' => 'O campo :attribute é obrigatório',
        'unique' => 'O campo :attribute precisa ser único',
        'file' => 'O campo :attribute ser do tipo arquivo',
        'mimes' => 'O campo :attribute precisa ser um arquivo nos formatos png, jpeg ou jpg',
        'min' => 'O campo :attribute precisa ter no mínimo :min caracteres',
        'digits_between' => 'O campo :attribute precisa ser um número entre :min e :max',
        'boolean' => 'O campo :attribute precisa ser verdadeiro ou falso',
        'exists' => 'O campo :attribute precisa ter um registro previamente criado'
    ];
}
}
