<?php

namespace App\Http\Requests;

class CategoryRequest extends FormRequest
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
        ];
    }
}
