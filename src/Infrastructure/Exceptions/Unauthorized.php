<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class Unauthorized extends HttpError
{
    protected string $publicMessage = 'Unauthorized';

    protected bool $shouldLog = false;

    function getHttpCode(): int
    {
        return 401;
    }
}
