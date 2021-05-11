<?php

declare(strict_types=1);

namespace Tests\Unit\Integration;

use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class ExampleTest extends Unit
{
    protected UnitTester $tester;

    public function testSuccess(): void
    {
        $this->assertEquals(1, 1);
    }
}
