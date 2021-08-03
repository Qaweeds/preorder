<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SelfpriceRequest extends FormRequest
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
            'selfprice-delivery' => 'required|exists:self_prices,delivery',
            'selfprice-country' => 'required|exists:self_prices,country',
            'selfprice-season' => 'required|exists:self_prices,season',
            'selfprice-group' => 'required|exists:self_prices,gg',
            'selfprice-val' => 'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'selfprice-val.required' => 'Укажите значение',
            'selfprice-val.gt' => ':attribute должен быть больше нуля',
        ];
    }

    public function attributes()
    {
        return [
            'selfprice-val' => 'Процент'
        ];
    }
}
