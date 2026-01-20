<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.app', function ($view) {
            if (! Schema::hasTable('categories')) {
                $view->with('navCategories', collect());
                return;
            }

            $navCategories = Cache::remember('nav.categories', now()->addMinutes(10), function () {
                return Category::query()
                    ->orderBy('name')
                    ->take(8)
                    ->get();
            });

            $view->with('navCategories', $navCategories);
        });

        View::composer('home', function ($view) {
            if (! Schema::hasTable('categories') || ! Schema::hasTable('products')) {
                $view->with([
                    'homeCategories' => collect(),
                    'featuredProducts' => collect(),
                ]);
                return;
            }

            $homeCategories = Cache::remember('home.categories', now()->addMinutes(10), function () {
                return Category::query()
                    ->orderBy('name')
                    ->take(6)
                    ->get();
            });

            $featuredProducts = Cache::remember('home.featured_products', now()->addMinutes(10), function () {
                return Product::query()
                    ->with('category')
                    ->where('is_active', true)
                    ->orderByDesc('id')
                    ->take(4)
                    ->get();
            });

            $view->with([
                'homeCategories' => $homeCategories,
                'featuredProducts' => $featuredProducts,
            ]);
        });
    }
}
