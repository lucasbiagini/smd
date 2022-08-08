<?php

namespace App\Http\Requests\Medida;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedidaRequest extends FormRequest
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
            'processo_id' => ['required', 'exists:processos,id'],
            'desc' => ['required', 'string'],
            'tipo' => ['required', 'integer', 'min:0', 'max:22'],
        ];
    }
}
