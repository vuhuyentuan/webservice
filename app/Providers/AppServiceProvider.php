<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
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

        view()->composer(['login', 'register', 'layouts.master'], function ($view) {
            $setting = Setting::find(1);
            $view->with(['setting' => $setting]);
        });
        Schema::defaultStringLength(191);
    }
}
