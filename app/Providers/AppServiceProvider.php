<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bootRepo();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Validator::extend('australian_mobile_number', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:\+?61|0)4\d{8}$/', $value);
        });
    }
    public function bootRepo(){
        $repoClass = [
            'DateDelivery',
            'History',
            'Location',
            'Orders',
            'School',
            'PostalCode'
        ];

        foreach ($repoClass as $repo_class) {
            $this->app->bind("App\Repositories\contracts\\{$repo_class}RepoInterface", "App\Repositories\\{$repo_class}Repo");
        }
    }
}
