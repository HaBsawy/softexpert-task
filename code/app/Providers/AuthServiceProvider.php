<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('store-task', function (User $user) {
            return $user['role'] === 'manager';
        });

        Gate::define('show-task', function (User $user, Task $task) {
            return $user['role'] === 'manager' || $user['id'] === $task['user_id'];
        });

        Gate::define('update-task', function (User $user, Task $task) {
            return $user['role'] === 'manager' || $user['id'] === $task['user_id'];
        });
    }
}
