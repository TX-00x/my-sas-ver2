<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('Administrator');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'contact_number' => 'required|string|max:100',
            'selected_factory_id' => 'required|integer',
            'selected_roles' => 'required|array'
        ];
    }
}
