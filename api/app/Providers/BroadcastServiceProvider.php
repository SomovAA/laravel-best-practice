<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Contracts\Broadcasting\Factory;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** @var BroadcastManager $broadcast */
        $broadcast = $this->app->get(Factory::class);
        $broadcast->routes();

        require $this->app->basePath('routes/channels.php');
    }
}
