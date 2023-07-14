<?php

namespace App\Providers;

use App\Models\Category;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


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
        View::composer('*', function ($view) {
            $categories = Category::all();
            $view->with('categories', $categories);
        });

        View::composer('*', function ($view) {
            $view->with('cartCount', CartFacade::getContent()->count());
        });

    }
}
