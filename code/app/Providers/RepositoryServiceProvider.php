<?php

namespace App\Providers;

use App\Repositories\Task\TaskEloquent;
use App\Repositories\Task\TaskInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(TaskInterface::class, TaskEloquent::class);
    }
}
