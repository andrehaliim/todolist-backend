<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TodoListRequest;
use App\Http\Requests\TodoListUpdateRequest;
use App\Models\Alarm;
use App\Models\TodoList;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TodoListController extends Controller
{
    protected function createResponse($param = array())
    {
        $status = !empty($param['status']) ? $param['status'] : 200;
        $message = !empty($param['message']) ? $param['message'] : 'OK';
        $data = !empty($param['data']) ? $param['data'] : [];

        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    public function show()
    {
        $user = User::find(Auth::id());
        
        $query = TodoList::selectRaw('todolist.*')->where('todolist.user_id', $user->id);        
        $data = $query->get();

        return response()->json($this->createResponse(['data' => $data]), 200);
    }

    public function store(TodoListRequest $request)
{
    try
    {
        $todolistData = $request->only(['user_id', 'title', 'text']);
        $todolist = TodoList::create($todolistData);

        if ($request->has('alarm')) 
        {
            $alarm_data = $request->input('alarm');

            $alarms = array_map(function ($arr) use ($todolist) 
            {
                return [
                    'datetime' => $arr['datetime'],
                    'status' => $arr['status'],
                    'user_id' => $todolist->user_id,
                    'todolist_id' => $todolist->id,
                ];
            }, $alarm_data);

            $todolist->todolist_alarm()->createMany($alarms);
        }

        return response()->json($this->createResponse(['data' => $todolist->id]), 200);    
    } 
    catch(Exception $e)
    {
        Log::error($e->getMessage());
        return response()->json(['message' => 'Failed to create todolist'], 404);
    } 
}


    public function update(TodoListUpdateRequest $request, $id)
    {
        $data = TodoList::find($id);

        if ($data) {
            $rules_array = collect(Config::get('boilerplate.todolist_update.validation_rules'));
            $rule_keys = $rules_array->keys()->toArray();
            $data->fill($request->only($rule_keys));

            if ($data->update()) {
                return response()->json($this->createResponse(["message" => "TodoList updated successfully."]), 200);
            } else {
                return response()->json(['message' => 'Failed to update todolist.'], 404);
            }
        } else {
            return response()->json(['message' => 'Cannot find todolist.'], 404);
        }        
    }

    public function delete($id)
    {
        $data = TodoList::find($id);
        if (!$data) {
            return response()->json(['message' => 'Cannot find todolist.'], 404);
        }

        if ($data->delete()) {
            return response()->json($this->createResponse(["message" => "TodoList deleted successfully."]), 200);
        } else {
            return response()->json(['message' => 'Failed to delete todolist.'], 404);
        }
    }

    public function detail($id)
    {
        $data = TodoList::find($id);
        if ($data) {
            return response()->json($this->createResponse(['data' => $data]), 200);
        } else {
            return response()->json(['message' => 'Cannot find todolist.'], 404);
        }
    }
}
