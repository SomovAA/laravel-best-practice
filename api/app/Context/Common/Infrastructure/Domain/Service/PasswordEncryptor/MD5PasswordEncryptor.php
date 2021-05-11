<?php

declare(strict_types=1);

namespace App\Context\Example\Infrastructure\Domain\Service;

use App\Context\Common\Domain\Service\PasswordEncryptor\PasswordEncryptorInterface;

class MD5PasswordEncryptor implements PasswordEncryptorInterface
{
    public function encrypt(string $password): string
    {
        return md5($password);
    }
}
