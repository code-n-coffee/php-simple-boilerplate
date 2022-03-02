<?php

declare(strict_types=1);

namespace App\Infrastructure\Router;

use App\Infrastructure\Exceptions\NotFound;
use App\Infrastructure\Request;
use App\Infrastructure\Response;

/**
 * Singleton Router
 */
class Router
{
    private static ?Router $instance = null;

    /**
     * @var Route[]
     */
    private array $routes = [];

    /**
     * protects construct to be called
     */
    protected function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function post(string $route, callable|string $class, ?string $method = null): void
    {
        self::addRoute(new Route(Request::POST, $route, $class, $method));
    }

    public static function get(string $route, callable|string $class, ?string $method = null): void
    {
        self::addRoute(new Route(Request::GET, $route, $class, $method));
    }

    public static function addRoute(Route $route): void
    {
        $router = self::getInstance();
        $router->pushRoute($route);
    }

    public function pushRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * @throws NotFound
     */
    public function run(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                $class = $route->getController();

                if (is_callable($class)) {
                    return $class($request);
                }

                $method = $route->getAction() ?? 'index';

                return (new $class())->$method($request);
            }
        }

        throw new NotFound();
    }
}
