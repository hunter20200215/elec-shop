<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Route::pattern('id', '[0-9]+');
        Route::pattern('attribute_id', '[0-9]+');
        if(\Schema::hasTable('settings')){
            $settings = Setting::first();
            View::share('settings', $settings);
        }
        Paginator::defaultView('pagination::bootstrap-4');
    }
}
