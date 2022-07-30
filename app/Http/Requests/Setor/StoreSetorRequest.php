<?php

namespace App\Http\Requests\Setor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetorRequest extends FormRequest
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
            'name' => ['required', 'min:1', 'max:250'],
            'desc' => ['required', 'min:1', 'max:500']
        ];
    }
}
