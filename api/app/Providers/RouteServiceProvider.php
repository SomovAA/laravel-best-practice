<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function (): void {
            /** @var Router $route */
            $route = $this->app->get('router');

            /** @var RouteRegistrar $routeRegistrar */
            $routeRegistrar = $route->prefix('api');

            $routeRegistrar
                ->middleware('api')
                ->namespace($this->namespace)
                ->group($this->app->basePath('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // ToDo: проверить работает ли это, скорей всего нужно добавить пользователя, если авторизован
        $rateLimiter = $this->app->get('Illuminate\Cache\RateLimiter');
        $rateLimiter->for('api', function (Request $request) {
            return Limit::perMinute(60)->by((string)$request->ip());
        });
    }
}
