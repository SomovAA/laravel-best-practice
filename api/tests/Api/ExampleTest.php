<?php

declare(strict_types=1);

namespace Tests\Api;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;

class ExampleTest extends Unit
{
    protected ApiTester $tester;

    public function testSuccess(): void
    {
        $this->tester->haveHttpHeader('Content-Type', 'application/json');
        $this->tester->sendPost('/example/test');

        $this->tester->seeResponseCodeIs(HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContainsJson([
            'success' => true,
        ]);
    }

    public function testNotFound(): void
    {
        $this->tester->haveHttpHeader('Content-Type', 'application/json');
        $this->tester->sendPost('/fake-page');

        $this->tester->seeResponseMatchesJsonType([
            'errors' => [
                [
                    'code' => 'string',
                    'message' => 'string',
                    'target' => 'string',
                ],
            ],
        ]);
    }
}
