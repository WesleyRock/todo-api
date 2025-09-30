<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Todo\StoreTodoRequest;
use App\Http\Requests\Api\V1\Todo\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Requests;

final class TodoController extends BaseApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $query = Todo::where('user_id', $user->id);

        if ($request->has('completed')) {
            $completed = filter_var(
                $request->query('completed'),
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            );

            if (!is_null($completed)) {
                $query->where('completed', $completed);
            }
        }

        $todos =$query->orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json($todos);
    }

    public function store(StoreTodoRequest $ruequest): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $todo = Todo::create($data);
        return response()->json($todo, 201);
    }

    public function update(UpdateTodoRequest $request, int $id): JsonResponse
    {
        $todo = Todo::findOrFail($id);

        $this->authorizeTodoOwner($request->user()->id, $todo);

        $data = $request->validated();
        $todo->update($data);

        return response()->json($todo);
    }
}
