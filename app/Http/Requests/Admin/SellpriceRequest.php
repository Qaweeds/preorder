<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SellpriceRequest extends FormRequest
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
            'sellprice-channel' => 'required|exists:sell_prices,channel',
            'sellprice-country' => 'required|exists:sell_prices,country',
            'sellprice-season' => 'required|exists:sell_prices,season',
            'sellprice-group' => 'required|exists:sell_prices,gg',
            'sellprice-val' => 'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'sellprice-val.required' => 'Укажите значение',
            'sellprice-val.gt' => ':attribute должен быть больше нуля',
        ];
    }

    public function attributes()
    {
        return [
            'sellprice-val' => 'Процент'
        ];
    }
}
