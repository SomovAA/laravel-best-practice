<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;

$app = require __DIR__ . '/../bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

return $app;
