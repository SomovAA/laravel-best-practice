<?php

declare(strict_types=1);

namespace App\Context\Common\Application\Service\User\Query;

class ViewUserQuery
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
