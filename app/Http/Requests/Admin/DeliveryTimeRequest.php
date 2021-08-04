<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTimeRequest extends FormRequest
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
            'delivery_time-country' => 'required|exists:delivery_times,country_id',
            'delivery_time-delivery' => 'required|exists:delivery_times,delivery',
            'delivery_time-val' => 'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'delivery_time-val.required' => 'Укажите значение',
            'delivery_time-val.gt' => 'Количество дней должно быть больше нуля',
        ];
    }

}
