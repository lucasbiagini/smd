<?php

namespace App\Http\Requests\Dado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDadoRequest extends FormRequest
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
            'categoria' => ['required', 'integer', 'min:0', 'max:10'],
            'desc' => ['required', 'string'],
            'tempo' => ['required', 'string'],
            'fonte' => ['required', 'integer', 'min:0', 'max:5'],
            'base_dados' => ['required_if:fonte,in:0']
        ];
    }
}
