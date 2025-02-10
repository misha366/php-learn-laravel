<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function ($user) {
            return $user->role->name === 'ROLE_ADMIN';
        });

        Gate::define('create-post', function ($user) {
            return in_array($user->role->name, ['ROLE_AUTHOR', 'ROLE_ADMIN']);
        });

        Gate::define('update-post', function ($user, Post $post) {
            return $user->role->name === "ROLE_ADMIN" || ($user->role->name === "ROLE_AUTHOR" && $user->id === $post->user_id);
        });

        // Если определили update-post, delete-post не надо?
        Gate::define('delete-post', function ($user, Post $post) {
            return $user->role->name === "ROLE_ADMIN" || ($user->role->name === "ROLE_AUTHOR" && $user->id === $post->user_id);
        });
    }
}
