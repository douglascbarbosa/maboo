<?php

namespace App\Providers;

use App\Book;
use App\Policies\BookPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       Book::class => BookPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function($user) {
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        // Passport::tokensCan([
        //     'manage-users' => 'Create, read, update and delete users (CRUD)',
        //     'manage-account' => 'Read your account data, id, name, email',
        //     'read-general' => 'Read general information'
        // ]);
    }
}
