<?php

declare(strict_types=1);

namespace App\Context\Common\Application;

use Closure;

interface TransactionManagerInterface
{
    public function beginTransaction(): void;

    /**
     * @return mixed
     */
    public function transactional(Closure $func);

    public function commit(): void;

    public function rollback(): void;
}
