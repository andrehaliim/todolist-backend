<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends BaseRequest
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
        return Config::get('boilerplate.user_create.validation_rules');
    }

    /**
     * Get custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.unique' => 'Username is already taken.',
            'email.unique' => 'Email is already taken.',
            'password.required' => 'Password is required.',
            'confirmation.same' => 'Password confirmation does not match.'
        ];
    }

    /**
     * Override failed validation response to combine all errors into one message.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // Get all validation error messages
        $errors = $validator->errors()->all();

        // Combine all error messages into a single string
        $message = implode(' ', $errors);

        // Return a custom response with a single message key
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], 422));
    }
}
