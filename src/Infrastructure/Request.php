<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\Exceptions\BadRequest;

class Request
{
    const GET  = 'GET';
    const POST = 'POST';

    private string $method;
    private string $path;
    private array  $parsedBody;
    private array  $cookies;

    public function __construct(string $method, string $path, array $parsedBody, array $cookies)
    {
        $this->method     = $method;
        $this->path       = str_starts_with($path, "/") ? $path : "/" . $path;
        $this->parsedBody = $parsedBody;
        $this->cookies    = $cookies;
    }

    /**
     * @throws BadRequest
     */
    public static function make(): self
    {
        return new self(
            $_SERVER["REQUEST_METHOD"],
            $_GET["_route"] ?? $_SERVER["REQUEST_URI"],
            self::parseBody(),
            $_COOKIE
        );
    }

    /**
     * Our request can handle form-urlencoded or json
     *
     * @throws BadRequest
     */
    private static function parseBody(): array
    {
        if (($_SERVER["CONTENT_TYPE"] ?? "") === "application/json") {
            $parsedBody = json_decode(file_get_contents("php://input"), true);

            if ($parsedBody === null) {
                throw new BadRequest("Your request has an invalid body");
            }

            return $parsedBody;
        }

        if (($_SERVER["CONTENT_TYPE"] ?? "") === "application/x-www-form-urlencoded" || !empty($_POST)) {
            return $_POST;
        }

        return [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getParsedBody(): array
    {
        return $this->parsedBody;
    }

    public function getCookie(string $key): ?string
    {
        return $this->cookies[$key] ?? null;
    }
}
