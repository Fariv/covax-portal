<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array(
            "name" => "required|string|max:255",
            "email" => "required|string|email|unique:App\Models\User,email|max:255",
            "nid" => "required|string|unique:App\Models\User,nid",
            "password" => "required|string|min:8",
            'center' => 'required|exists:vaccine_centers,id',
            'timezone' => 'required|string',
        );
    }

    public function messages()
    {
        return array(
            'name.required' => 'Please enter your name.',
            'email.required' => 'An email address is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'This email is already registered.',
            'nid.required' => 'An nid is required.',
            'nid.unique' => 'This nid is already registered.',
            'center.required' => 'Please choose a center, the field is required.',
            'password.required' => 'You must provide a password.',
            'password.min' => 'Password must be at least 8 characters long.',
        );
    }
}
