<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Traits\ApiResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    use ApiResponse;

    public function show()
    {
        $data = User::selectRaw('users.*')->get();
        return $this->success($data);
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->only(['username', 'name', 'email', 'password']);
            $params['password'] = Hash::make($params['password']);
            $data = User::create($params);
            DB::commit();

            return $this->success($data);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error('Unable to create user: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $data = User::find($id);
        if (!$data) {
            throw new HttpException(404, 'Cannot find user.');
        }

        if ($data->delete()) {
            return $this->success(["message" => "User deleted successfully."]);
        } else {
            throw new HttpException(400, 'Failed to delete user.');
        }
    }
}
