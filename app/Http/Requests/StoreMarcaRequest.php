<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
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
            'nome' => 'required|unique:marcas',
            'imagem' => 'required|file|mimes:png,jpeg,jpg'
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
    ];
}
}
