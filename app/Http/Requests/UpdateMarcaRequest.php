<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarcaRequest extends FormRequest
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
        $marcaId = $this->route('marca');

        return [
            'nome' => "min:3|unique:marcas,nome,{$marcaId},id",
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
        'unique' => 'O valor do campo :attribute já existe',
        'min' => 'O campo :attribute deve ter no mínimo :min caracteres',
        'required' => 'O campo :attribute não pode ser vazio',
    ];
}
}
