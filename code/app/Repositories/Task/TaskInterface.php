<?php

namespace App\Repositories\Task;

use App\Http\Requests\API\StoreTaskRequest;
use App\Http\Requests\API\UpdateTaskRequest;
use App\Models\Task;

interface TaskInterface
{
    public function all();

    public function currentUserTasks();

    public function store(StoreTaskRequest $request);

    public function update(UpdateTaskRequest $request, Task $task);

    public function updateStatus(UpdateTaskRequest $request, Task $task);
}
