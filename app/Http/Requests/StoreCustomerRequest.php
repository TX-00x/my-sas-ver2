<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email',
            'description' => 'nullable|string|max:255',
//            'cs_agent_id' => 'required|integer',
//            'sales_agent_id' => 'required|integer',
            'logo_id' => 'nullable|integer',
            'csAgents' => 'required|array',
            'salesAgents' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'email.required' => 'Email field is required!',
            'cs_agent_id.required' => 'Customer Service agent field is required!',
            'sales_agent_id.required' => 'Sales agent field is required!',
        ];
    }
}
