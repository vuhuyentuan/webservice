<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.sidebar'], function ($view) {
            $category = Category::select('id', 'name', 'image', 'status')
                                ->with('service')
                                ->get();
            $view->with(['category' => $category]);
            });
        Schema::defaultStringLength(191);
    }
}
