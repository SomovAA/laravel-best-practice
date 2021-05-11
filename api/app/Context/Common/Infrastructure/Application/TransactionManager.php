<?php

declare(strict_types=1);

use App\Context\Common\Application\TransactionManagerInterface;
use Illuminate\Database\DatabaseManager;

class TransactionManager implements TransactionManagerInterface
{
    private DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function beginTransaction(): void
    {
        $this->databaseManager->beginTransaction();
    }

    public function transactional(Closure $func): void
    {
        $this->databaseManager->transaction($func);
    }

    public function commit(): void
    {
        $this->databaseManager->commit();
    }

    public function rollback(): void
    {
        $this->databaseManager->rollBack();
    }
}
