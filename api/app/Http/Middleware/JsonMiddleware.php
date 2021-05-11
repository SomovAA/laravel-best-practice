<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JsonException;

class JsonMiddleware
{
    /**
     * @return mixed
     * @throws JsonException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isJson()) {
            throw new JsonException('Wrong content-type.');
        }

        if ($request->getContent() === '') {
            throw new JsonException('Request body is empty.');
        }

        if ($this->jsonIsValid((string)$request->getContent())) {
            return $next($request);
        }

        throw new JsonException(json_last_error_msg(), json_last_error());
    }

    private function jsonIsValid(string $content): bool
    {
        json_decode($content);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
