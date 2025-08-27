<?php
declare(strict_types=1);

namespace Core;

class Router
{
    private array $routes = [];
    private string $prefix = '';

    public function get(string $path, string $action): void
    {
        $this->add('GET', $path, $action);
    }

    public function post(string $path, string $action): void
    {
        $this->add('POST', $path, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $previous = $this->prefix;
        $this->prefix .= rtrim($prefix, '/');
        $callback($this);
        $this->prefix = $previous;
    }

    private function add(string $method, string $path, string $action): void
    {
        $pattern = $this->prefix . $path;
        $this->routes[] = [$method, $pattern, $action];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        foreach ($this->routes as [$m, $pattern, $action]) {
            if ($m !== $method) {
                continue;
            }
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
            $regex = '#^' . rtrim($regex, '/') . '$#';
            if (preg_match($regex, rtrim($path, '/'), $matches)) {
                array_shift($matches);
                $this->invoke($action, $matches);
                return;
            }
        }
        http_response_code(404);
        echo 'Not Found';
    }

    private function invoke(string $action, array $params): void
    {
        [$controller, $method] = explode('@', $action);
        $controllerClass = 'App\\Controllers\\' . $controller;
        $instance = new $controllerClass();
        $instance->$method(...$params);
    }
}
