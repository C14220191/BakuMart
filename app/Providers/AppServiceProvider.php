<?php

namespace App\Providers;

use App\Http\Middleware\Role;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RedirectIfAuthenticated::redirectUsing(fn() => route('home'));

        Gate::define('user', fn(User $user) => $user->role == 'user');
        Gate::define('admin', fn(User $user) => $user->role == 'admin');

        Route::aliasMiddleware('role', Role::class);
    }
}
