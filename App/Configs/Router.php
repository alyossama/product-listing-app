<?php

declare(strict_types=1);

namespace App\Configs;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    function register(string $requestMethod, string $route, $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    function get(string $route, $action): self
    {
        $this->register('GET', $route, $action);
        return $this;
    }

    function post(string $route, $action): self
    {
        $this->register('POST', $route, $action);
        return $this;
    }

    function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;
            if (class_exists($class)) {
                $class = new $class();
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
