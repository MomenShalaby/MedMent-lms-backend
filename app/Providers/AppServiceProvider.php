<?php

namespace App\Providers;

use App\Models\Experience;
use App\Policies\ExperiencePolicy;
// use Illuminate\Auth\Access\Gate;
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
        //
        // Gate::policy(Experience::class, ExperiencePolicy::class);
    }
}
