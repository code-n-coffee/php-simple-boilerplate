<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class BadRequest extends HttpError
{
    protected string $publicMessage = 'Bad Request';

    protected bool $shouldLog = false;

    function getHttpCode(): int
    {
        return 400;
    }
}
