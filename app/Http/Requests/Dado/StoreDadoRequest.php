<?php

namespace App\Http\Requests\Dado;

use Illuminate\Foundation\Http\FormRequest;

class StoreDadoRequest extends FormRequest
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
            'categoria' => ['required', 'integer', 'min:0', 'max:63'],
            'desc' => ['required', 'string'],
            'tempo' => ['required', 'string'],
            'fonte' => ['required', 'integer', 'min:0', 'max:5'],
            'base_dados' => ['required_if:fonte,in:0']
        ];
    }
}
