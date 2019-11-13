<?php

namespace App\Http\Requests;

class UpdateProductRequest extends FormRequest
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
            'name' => 'min:3|max:255',
            'image' => 'image|max:4096'
        ];
    }
}
