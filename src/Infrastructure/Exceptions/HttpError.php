<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Throwable;

abstract class HttpError extends \Exception
{
    protected string $publicMessage = '';

    protected bool $shouldLog = true;

    /**
     * Exceptions that will be handled towards a http response
     *
     * @param string|null $publicMessage - A message that can be public exposed
     * @param bool|null $shouldLog - Whether to be logged or not (default true, but can be changed by the implementation)
     * @param string|null $logMessage - The private message that will be logged
     * @param Throwable|null $previous - previous exception
     */
    public function __construct(?string $publicMessage = null, ?bool $shouldLog = null, ?string $logMessage = null, ?Throwable $previous = null)
    {
        $this->publicMessage = $publicMessage ?? $this->publicMessage;
        $this->shouldLog     = $shouldLog ?? $this->shouldLog;

        parent::__construct($logMessage ?? $this->publicMessage, 0, $previous);
    }

    /**
     * Returns the appropriate http code to be return in case this exception explodes
     */
    abstract function getHttpCode(): int;

    /**
     * Returns a message without sensitive information
     */
    public function getPublicMessage(): string
    {
        return $this->publicMessage;
    }

    /**
     * Whether if this exception should be logged when handled or not
     */
    public function shouldLog(): bool
    {
        return $this->shouldLog;
    }
}
