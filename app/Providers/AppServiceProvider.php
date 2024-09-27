<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('admin', function ($user) {
            return $user->is_admin === '1'; // is_adminが '1' の場合に true を返す
        });

        Gate::define('edit_update', function ($user, $authUser, $editingUser) {
            return $authUser->is_admin === '1' || $authUser->id === $editingUser->id;
        });
    }
}
