<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use App\Policies\AuthorPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\LoanPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Author::class, AuthorPolicy::class);
        Gate::policy(Loan::class, LoanPolicy::class);
        Gate::policy(User::class,UserPolicy::class);
    }
}
