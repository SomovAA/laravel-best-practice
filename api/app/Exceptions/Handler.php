<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use JsonException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $flattenException = FlattenException::createFromThrowable($e);

        if ($e instanceof JsonException) {
            $statusCode = 400;
        } else {
            $statusCode = $flattenException->getStatusCode();
        }

        return new JsonResponse(
            [
                'errors' => [
                    [
                        'code' => 'exception',
                        'message' => $flattenException->getMessage(),
                        'target' => '',
                    ],
                ],
            ],
            $statusCode,
            $flattenException->getHeaders()
        );
    }
}
