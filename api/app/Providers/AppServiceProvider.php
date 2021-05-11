<?php

declare(strict_types=1);

namespace App\Providers;

use App\Context\Common\Application\Service\User\UserService;
use App\Context\Common\Application\Service\User\UserServiceInterface;
use App\Context\Common\Domain\Model\User\UserRepositoryInterface;
use App\Context\Common\Infrastructure\Domain\Model\User\PGUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, PGUserRepository::class);
        $this->app->singleton(UserServiceInterface::class, UserService::class);
    }
}
