<?php

declare(strict_types=1);

namespace Tests\Functional;

use Codeception\Test\Unit;
use Tests\Support\FunctionalTester;

class ExampleTest extends Unit
{
    protected FunctionalTester $tester;

    public function testSuccess(): void
    {
        $this->assertEquals(1, 1);
    }
}
