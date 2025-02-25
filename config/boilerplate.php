<?php

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

return [
    'user_login' => [
        'validation_rules' => [
            'username' => 'required|string',
            'password' => 'required|string',
        ]
    ],

    'user_create' => [
      'validation_rules' => [
          'username' => 'required|string|unique:users,username',
          'name' => 'required|string',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|string',
          'confirmation' => 'required|string|same:password',
        ]
    ],

    'user_update' => [
      'validation_rules' => [
          'name' => 'nullable|string',
          'email' => 'nullable|email',
          'role' => 'nullable|string',
          'password' => 'nullable|string',
          'is_active' => 'nullable|boolean',
      ]
    ],

    'todolist_create' => [
        'validation_rules' => [
          'user_id' => 'required|numeric|exists:users,id',
          'title' => 'required|string',
          'text' => 'required|string',

          'alarm' => 'nullable|array',
          'datetime' => 'nullable|date_format:Y-m-d H:i:s',
          'status' => ['nullable', 'string', 'max:20', Rule::in(['active', 'inactive'])],
        ]
    ],
  
      'alarm_create' => [
        'validation_rules' => [
            'datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'status' => ['nullable', 'string', 'max:20', Rule::in(['active', 'inactive'])],
          ]
    ],
];
