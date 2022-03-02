<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class NotFound extends HttpError
{
    protected string $publicMessage = 'Not Found';

    protected bool $shouldLog = false;

    function getHttpCode(): int
    {
        return 404;
    }
}
