<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmbellishmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.type' => 'bail|required|unique:embellishment_types,type',
        ];
    }

    public function messages()
    {
        return [
            '*.type.required' => 'Embellishment Type field is required!',
            '*.type.unique' => 'Embellishment Type already exists!',
        ];
    }
}
