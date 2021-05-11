<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\AbstractController;
use Illuminate\Http\JsonResponse;

class ExampleController extends AbstractController
{
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
        ]);
    }
}
