<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
        //"App\Todos" => 'App\Policies\TodosPolicy',
        User::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function($user){
          $role = $user->user_type;
          return $role == 1;
        });
        // Gate::define('isAdmin', function($user){
        //   $role = $user->user_type->pluck('user_type')->toArray();
        //   return inArray('1',$role);
        // });

        //
        //Gate::define('allow_edit','App\Gate\Gate@allowaction')
    }
}
