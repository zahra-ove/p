<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Permission::all()->map(function ($permission) {
            Gate::define($permission->name_en, function ($user) use ($permission) {
                return $user->hasPermission($permission->name_en);
            });
        });
        Permission::all()->map(function ($permission) {
            Gate::define($permission->name_en, function ($user) use ($permission) {
                return $user->hasPermissions($permission->name_en);
            });
        });
    }
}
