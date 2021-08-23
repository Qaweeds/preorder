<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
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
            'file' => 'required|max:3',
            'file.*' => 'required',
            'group' => 'required',
            'category' => 'required',
            'ready_or_not' => 'required',
            'country' => 'required',
            'delivery' => 'required',
            'channel' => 'required',
            'season' => 'required',
            'price' => 'required | numeric'
        ];
    }

    public function messages()
    {
        return [
            'file.max' => 'Не больще 3х фото',
            'file.*' => 'Требуется фото',
            'channel.required' => "Выберите канал",
            'category.required' => "Выберите категорию",
            'group.required' => "Выберите подгруппу",
        ];
    }
}
