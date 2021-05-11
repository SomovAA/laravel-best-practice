<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Context\Common\Domain\Model\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
    }
}
