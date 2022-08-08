<?php

namespace App\Http\Requests\Compartilhamento;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompartilhamentoRequest extends FormRequest
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
            'nome_instituicao' => ['required', 'string'],
            'dados_compartilhados' => ['required', 'array'],
            'finalidade' => ['required', 'string']
        ];
    }
}
