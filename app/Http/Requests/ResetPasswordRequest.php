<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to request a password reset
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
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'token.required' => 'A reset token is required to proceed. Please check your email for the reset link.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'The email address entered does not appear to be valid. Please check and try again.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'Your new password must be at least 8 characters long. Please choose a more secure password.',
            'password.confirmed' => 'The password confirmation does not match. Please make sure both passwords are identical.',
        ];
    }
    
}
