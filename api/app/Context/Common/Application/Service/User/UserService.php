<?php

declare(strict_types=1);

namespace App\Context\Common\Application\Service\User;

use App\Context\Common\Application\Service\User\Command\CreateUserCommand;
use App\Context\Common\Application\Service\User\Dto\UserDto;
use App\Context\Common\Application\Service\User\Query\ViewUserQuery;
use App\Context\Common\Domain\Model\User\User;
use App\Context\Common\Domain\Model\User\UserRepositoryInterface;
use Exception;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(CreateUserCommand $command): void
    {
        $user = $this->userRepository->findByEmail($command->getEmail());

        if (!is_null($user)) {
            throw new Exception('Email already exists');
        }

        $user = User::createByParams($command->getName(), $command->getEmail(), $command->getPassword());

        $this->userRepository->add($user);
    }

    public function view(ViewUserQuery $query): UserDto
    {
        $user = $this->userRepository->findById($query->getId());

        if (is_null($user)) {
            throw new Exception('User not found');
        }

        $userDto = new UserDto();
        $userDto->name = $user->getName();

        return $userDto;
    }
}
