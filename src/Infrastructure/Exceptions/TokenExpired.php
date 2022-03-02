<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class TokenExpired extends HttpError
{
    protected string $publicMessage = 'Proxy Authentication Required';

    protected bool $shouldLog = false;

    function getHttpCode(): int
    {
        return 407;
    }
}
