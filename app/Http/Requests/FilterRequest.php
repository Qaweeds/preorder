<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'fio' => 'sometimes|nullable|exists:products,user_id',
            'category' => 'sometimes|nullable|exists:products,category_id',
            'country' => 'sometimes|nullable|exists:products,country_id',
            'season' => 'sometimes|nullable|exists:products,season',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        dd($validator->errors());
    }
}
