<?php

namespace App\Requests\Auth;

use App\Constants\AuthConstants;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change to false if you want to restrict access
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return AuthConstants::LOGIN_ACTION[AuthConstants::VALIDATION];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return AuthConstants::LOGIN_ACTION[AuthConstants::VALIDATION_MESSAGES];
    }
}
