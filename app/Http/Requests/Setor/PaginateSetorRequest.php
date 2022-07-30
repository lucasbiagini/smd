<?php

namespace App\Http\Requests\Setor;

use Illuminate\Foundation\Http\FormRequest;

class PaginateSetorRequest extends FormRequest
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
            'sortBy' => ['required', 'in:id,name,email'],
            'sortDirection' => ['required', 'in:asc,desc'],
            'perPage' => ['required', 'integer']
        ];
    }
}
