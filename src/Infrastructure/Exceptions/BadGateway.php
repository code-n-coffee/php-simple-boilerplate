<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class BadGateway extends HttpError
{
    protected string $publicMessage = 'Bad Gateway';

    function getHttpCode(): int
    {
        return 502;
    }
}
