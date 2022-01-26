<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:3|max:65',
            'description' => 'required|min:3|max:550',
            'short_description' => 'required|min:3|max:350',
            'old_price' => 'required',
            'shop_id' => 'required|exists:shops,id',
        ];
    }
}
