<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\View\Composers\CategoryComposer;
use App\View\Composers\RecentOrdersComposer;

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
        //registering the main menu category composer at the top of the page
        //Now every Blade file, including app.blade.php, has access to $categories.
        View::composer('*', CategoryComposer::class);

        // New: Recent orders only for admin layout
        View::composer('layouts.admin', RecentOrdersComposer::class);
    }
}
