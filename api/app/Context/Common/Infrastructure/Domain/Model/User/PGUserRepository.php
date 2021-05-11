<?php

declare(strict_types=1);

namespace App\Context\Common\Infrastructure\Domain\Model\User;

use App\Context\Common\Domain\Model\User\User;
use App\Context\Common\Domain\Model\User\UserRepositoryInterface;

class PGUserRepository implements UserRepositoryInterface
{
    public function add(User $user): void
    {
        $user->save();
    }

    public function findById(int $id): ?User
    {
        /** @var User|null $user */
        $user = User::query()->find($id);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user = User::query()->where([
            'email' => $email,
        ])->first();

        return $user;
    }
}
