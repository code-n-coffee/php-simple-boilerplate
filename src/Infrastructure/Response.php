<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\Exceptions\HttpError;

class Response
{
    private string $body;
    private int    $httpCode;
    private array  $headers;

    public function __construct(string $body, $httpCode = 200, array $headers = [])
    {
        $this->body     = $body;
        $this->httpCode = $httpCode;
        $this->headers  = $headers;
    }

    public static function view(string $view): self
    {
        return new self(file_get_contents(__VIEW_DIR__ . '/' . $view));
    }

    public static function exception(HttpError $exception): Response
    {
        $httpCode = $exception->getHttpCode();
        $publicMessage = $exception->getPublicMessage();

        if (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'application/json') {
            return self::json(['message' => $publicMessage], $httpCode);
        }

        return new self($publicMessage, $httpCode);
    }

    public static function json(array $data = [], int $httpCode = 200, array $headers = []): Response
    {
        return new self(json_encode($data), $httpCode, array_merge($headers, ['content-type:application/json']));
    }

    public function render(): void
    {
        // quick note: will not affect the request if it already started the output (like a php warning)
        http_response_code($this->httpCode);

        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }
}
