<?php

declare(strict_types=1);

namespace App\Context\Common\Application\Service\User;

use App\Context\Common\Application\Service\User\Command\CreateUserCommand;
use App\Context\Common\Application\Service\User\Dto\UserDto;
use App\Context\Common\Application\Service\User\Query\ViewUserQuery;

interface UserServiceInterface
{
    public function create(CreateUserCommand $command): void;

    public function view(ViewUserQuery $query): UserDto;
}
