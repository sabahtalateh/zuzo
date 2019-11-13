<?php

namespace App\Http\Requests;

class ProductRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'details' => 'required',
            'category_id' => 'required',
            'image' => 'image|max:4096'
        ];
    }
}
