<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ProductCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use MercadoPago\MercadoPagoConfig;
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
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $navCategories = Cache::remember('nav_categories_v1', now()->addMinutes(30), function () {
                return Category::query()
                    ->orderBy('category')
                    ->take(12)
                    ->get();
            });

            $navCartCount = Auth::check()
                ? ProductCart::where('user_id', Auth::id())->count()
                : collect(session('cart', []))->sum();

            $view->with([
                'navCategories' => $navCategories,
                'navCartCount' => $navCartCount,
            ]);
        });

        if (class_exists(MercadoPagoConfig::class)) {
            $accessToken = config('mercadopago.access_token');

            if (is_string($accessToken) && $accessToken !== '') {
                MercadoPagoConfig::setAccessToken($accessToken);
                MercadoPagoConfig::setRuntimeEnviroment(
                    app()->environment('local') ? MercadoPagoConfig::LOCAL : MercadoPagoConfig::SERVER
                );
            }
        }
    }
}
