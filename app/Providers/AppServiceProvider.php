<?php

namespace App\Providers;

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
        
    }
    public function bootRepo(){
        $repoClass = [
            'DateDelivery',
            'History',
        ];

        foreach ($repoClass as $repo_class) {
            $this->app->bind("App\Repositories\contracts\\{$repo_class}RepoInterface", "App\Repositories\\{$repo_class}Repo");
        }
    }
}
