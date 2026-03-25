<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Course; // Make sure to import your Course model
use App\Models\courses;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share courses with specific views
        View::composer([
            'layouts.welcomelayout',
            'auth.register',
            // Add any other views that use this layout
        ], function ($view) {
            $view->with('coursese',courses::all());
        });

        // Alternative: Share with all views (use cautiously)
        // View::share('coursese', Course::all());
    }
}