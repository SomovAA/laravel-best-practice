<?php

declare(strict_types=1);

namespace App\Core;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function isStage(): bool
    {
        return $this['env'] === 'stage';
    }

    public function isTesting(): bool
    {
        return $this['env'] === 'testing';
    }
}
