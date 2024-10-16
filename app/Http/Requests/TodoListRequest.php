<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TodoListRequest extends BaseRequest
{
    public function rules()
    {
        return Config::get('boilerplate.todolist_create.validation_rules');
    }

    public function authorize()
    {
        return true;
    }

        /**
     * Get custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [  
            'user_id.required' => 'User ID is required.',
            'title.required' => 'Title is required.',
            'text.required' => 'Text is required.',
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
