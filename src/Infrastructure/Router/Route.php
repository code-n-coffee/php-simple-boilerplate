<?php

declare(strict_types=1);

namespace App\Infrastructure\Router;

use App\Infrastructure\Request;
use Closure;

/**
 * Represents a single route to the Router
 */
class Route
{
    private string $method;
    private string $route;
    private Closure|string $controller;
    private null|string $action;

    public function __construct(string $method, string $route, callable|string $controller, ?string $action = null)
    {
        $this->method     = $method;
        $this->route      = $route;
        $this->controller = $controller;
        $this->action     = $action;
    }

    public function match(Request $request): bool
    {
        if ($this->method !== $request->getMethod()) {
            return false;
        }

        if ($this->route !== $request->getPath()) {
            return false;
        }

        return true;
    }

    public function getController(): Closure|string
    {
        return $this->controller;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }
}
