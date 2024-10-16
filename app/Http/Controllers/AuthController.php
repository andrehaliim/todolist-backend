<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\ApiResponse;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request) {
        $rules_array = collect(Config::get('boilerplate.user_login.validation_rules'));
        $rule_keys = $rules_array->keys()->toArray();

        $params = $request->only($rule_keys);
        $user = User::where('username', $params['username'])->first();

        $is_valid_password = $user ? Hash::check($params['password'], $user->password) : false;
        if ($user && $is_valid_password) {
            Auth::login($user);
            $token = auth()->user()->createToken('API Token')->plainTextToken;
    
            return $this->success([
                'token' => $token,
            ])->header('Authorization', 'Bearer ' . $token);
        } else {
            return $this->error('Invalid username or password!', 401);
        }

        return $this->success($params);
    }

    public function me()
    {
        $user = User::find(Auth::id());

        return $this->success($user);
    }

    public function logout()
    {
        if (Auth::check() || Sanctum::check()) {
            $user = auth()->user();
            $user->currentAccessToken()->delete();
            return ['message' => 'Successfully logged out'];
        }
    
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}