<?php

declare(strict_types=1);

namespace App\Context\Common\Domain\Service\PasswordEncryptor;

interface PasswordEncryptorInterface
{
    public function encrypt(string $password): string;
}
