<?php

namespace App\Http\Requests\Operador;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperadorRequest extends FormRequest
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
            'prop' => ['required', 'in:coleta,retencao,processamento,compartilhamento,eliminacao'],
            'value' => ['required', 'in:0,1']
        ];
    }
}
