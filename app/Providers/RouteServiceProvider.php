<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @param  \Illuminate\Http\Request     $request
     * @return void
     */
    public function map(Router $router, Request $request)
    {
        $locale = $request->segment(1);

        if(!isset(config('app.locales_dir')[$locale])) {
            $locale = config('app.fallback_locale');
        }

        $this->app->setLocale($locale);

        view()->share('lang', \App::getLocale());
        view()->share('dir', config('app.locales_dir')[\App::getLocale()]);
        view()->share('langs', config('app.locales'));

        $router->group(['namespace' => $this->namespace, 'prefix' => $locale], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
