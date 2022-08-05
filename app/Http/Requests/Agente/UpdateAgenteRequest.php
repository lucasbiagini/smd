<?php

namespace App\Http\Requests\Agente;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgenteRequest extends FormRequest
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
            'prop' => ['required', 'in:nome,endereco,cep,telefone,email'],
            'value' => ['string', 'nullable']
        ];
    }
}
