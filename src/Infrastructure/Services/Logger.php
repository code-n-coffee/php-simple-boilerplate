<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use DateTimeImmutable;

class Logger
{
    public static function log(string $message): void
    {
        $message = sprintf("[%s] %s \n", (new DateTimeImmutable())->format("Y-m-d H:i:s"), $message);

        if (getenv('ENV') === "production") {
            file_put_contents("php://stderr", $message); // heroku
        } else {
            file_put_contents(__ETC_DIR_ . "/app.log", $message, FILE_APPEND);
        }
    }

    public static function logException(\Throwable $e): void
    {
        self::log(sprintf(
            "[exception] %s\n%s:%s",
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        ));
    }
}
