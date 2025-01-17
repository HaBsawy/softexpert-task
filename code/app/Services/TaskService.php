<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\API\StoreTaskRequest;
use App\Http\Requests\API\UpdateTaskRequest;
use App\Http\Resources\API\TaskResource;
use App\Models\Task;
use App\Repositories\Task\TaskInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class TaskService
{
    public function __construct(private TaskInterface $taskRepo)
    {
    }

    public function index(): JsonResponse
    {
        $tasks = $this->currentUserIsManager() ?
            $this->taskRepo->all() :
            $this->taskRepo->currentUserTasks();

        return ResponseHelper::make(TaskResource::collection($tasks));
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        if (auth()->user()->cannot('store-task')) {
            return ResponseHelper::accessDenied();
        }

        $task = $this->taskRepo->store($request);

        return ResponseHelper::make(new TaskResource($task), 201,
            true, 'task created successfully.');
    }

    public function show(Task $task): JsonResponse
    {
        if (auth()->user()->cannot('show-task', $task)) {
            return ResponseHelper::accessDenied();
        }

        return ResponseHelper::make(new TaskResource($task->load('children')));
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        if (auth()->user()->cannot('update-task', $task)) {
            return ResponseHelper::accessDenied();
        }

        if ($this->taskCannotBeCompleted($request, $task)) {
            return ResponseHelper::make(null, 400,
                false, 'task has non completed children.');
        }

        $task = $this->currentUserIsManager() ?
            $this->taskRepo->update($request, $task):
            $this->taskRepo->updateStatus($request, $task);

        return ResponseHelper::make(new TaskResource($task), '202',
            true, 'task updated successfully.');
    }

    private function currentUserIsManager(): bool
    {
        return auth()->user()['role'] === 'manager';
    }

    private function taskCannotBeCompleted(Request $request, Task $task): bool
    {
        if ($request->get('status') === 'completed') {
            $nonCompletedChildrenCount = $task->children()
                ->where('status', '!=', 'completed')->count();

            return $nonCompletedChildrenCount > 0;
        }

        return false;
    }
}
