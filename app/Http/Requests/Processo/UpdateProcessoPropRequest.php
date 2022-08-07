<?php

namespace App\Http\Requests\Processo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcessoPropRequest extends FormRequest
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
            'prop' => ['required', 'in:desc,abrangencia,fonte,hipotese,finalidade,previsao_legal,resultados,beneficios,frequencia,quantidade'],
            'value' => ['alpha_num']
        ];
    }
}
