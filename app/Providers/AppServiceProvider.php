<?php

namespace App\Providers;

use App\Models\Preorder\Product;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();

        view()->composer('layouts.include.filter_form', function ($view) {
            $view->with('seasons', Product::query()->distinct()->pluck('season'));
            $view->with('countries', Product::query()->distinct()->with('country:id,name')->get(['country_id']));
            $view->with('users', Product::query()->distinct()->with('user:id,name')->get(['user_id']));
            $view->with('categories', Product::query()->distinct()->with('category:id,name')->get(['category_id']));
        });
    }
}
