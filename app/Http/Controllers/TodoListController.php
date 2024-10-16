<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TodoListRequest;
use App\Http\Requests\TodoListUpdateRequest;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        
        DB::statement(DB::raw('set @rownum=0'));
        $query = TodoList::selectRaw('todolist.*')->where('todolist.user_id', $user->id);

        $qb = QueryBuilder::for($query)->allowedSorts(
            [
            ])
            ->allowedFilters(
            [
            ])->distinct();

        
        $data = $qb->get();

        return response()->json($this->createResponse(['data' => $data]), 200);
    }

    public function store(TodoListRequest $request)
    {
        $rules_array = collect(Config::get('boilerplate.todolist_create.validation_rules'));
        $rule_keys = $rules_array->keys()->toArray();

        $data = TodoList::create($request->only($rule_keys));
        return response()->json($this->createResponse(['data' => $data->id]), 200);
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
