<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class UnhandledException extends HttpError
{
    protected string $publicMessage = 'Internal Server Error';

    function getHttpCode(): int
    {
        return 500;
    }
}
