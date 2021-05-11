<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\JsonMiddleware;
use App\Http\Middleware\TrustHosts;
use App\Http\Middleware\TrustProxies;
use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        ValidatePostSize::class,
        JsonMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
            SubstituteBindings::class,
            JsonMiddleware::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ToDo: избавиться от всего не можем, т.к. другие пакеты могут использовать эти алиасы...
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'can' => Authorize::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        //'guest' => '',
        //'cache.headers' => SetCacheHeaders::class,
        //'password.confirm' => RequirePassword::class,
    ];
}
