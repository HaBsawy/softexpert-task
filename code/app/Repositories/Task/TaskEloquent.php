<?php

namespace App\Repositories\Task;

use App\Http\Requests\API\StoreTaskRequest;
use App\Http\Requests\API\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskEloquent implements TaskInterface
{
    public function all(): Collection|array
    {
        return Task::query()
            ->with('children')
            ->when(request('status'), function (Builder $query) {
                $query->where('status', request('status'));
            })
            ->when(request('user_id'), function (Builder $query) {
                $query->where('user_id', request('user_id'));
            })
            ->when(request('from'), function (Builder $query) {
                $query->whereDate('due_date', '>', request('from'));
            })
            ->when(request('to'), function (Builder $query) {
                $query->whereDate('due_date', '<', request('to'));
            })
            ->whereNull('parent_id')
            ->get();
    }

    public function currentUserTasks(): Collection|array
    {
        return Task::query()
            ->with('children')
            ->where('user_id', auth()->id())
            ->when(request('status'), function (Builder $query) {
                $query->where('status', request('status'));
            })
            ->when(request('from'), function (Builder $query) {
                $query->whereDate('due_date', '>', request('from'));
            })
            ->when(request('to'), function (Builder $query) {
                $query->whereDate('due_date', '<', request('to'));
            })
            ->whereNull('parent_id')
            ->get();
    }

    public function store(StoreTaskRequest $request): Task|Model|Builder
    {
        return Task::query()->create([
            'user_id' => $request->get('user_id'),
            'parent_id' => $request->get('parent_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'due_date' => $request->get('due_date'),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): ?Task
    {
        $task->update([
            'user_id' => $request->get('user_id', $task['user_id']),
            'status' => $request->get('status', $task['status']),
            'title' => $request->get('title', $task['title']),
            'description' => $request->get('description', $task['description']),
            'due_date' => $request->get('due_date', $task['due_date']),
        ]);

        return $task->fresh();
    }

    public function updateStatus(UpdateTaskRequest $request, Task $task): ?Task
    {
        $task->update([
            'status' => $request->get('status', $task['status'])
        ]);

        return $task->fresh();
    }
}
