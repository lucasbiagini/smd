<?php

namespace App\Http\Requests\Transferencia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransferenciaRequest extends FormRequest
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
            'organizacao' => ['required', 'string'],
            'pais' => ['required', 'string'],
            'garantia' => ['required', 'integer', 'min:0', 'max:15'],
        ];
    }
}
