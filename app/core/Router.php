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
<<<<<<< HEAD
        // Raw path from the requested URI
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Detect the base path (folder where index.php lives), e.g. "/myapp"
        $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($scriptDir !== '' && $scriptDir !== '/') {
            // Remove base path prefix from the request path
            if (strpos($path, $scriptDir) === 0) {
                $path = substr($path, strlen($scriptDir));
                if ($path === false) { $path = '/'; }
            }
        }

        // Ensure leading slash and no trailing slash (consistent with your matching)
        $path = '/' . ltrim($path, '/');
        $path = rtrim($path, '/');

=======
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4
        foreach ($this->routes as [$m, $pattern, $action]) {
            if ($m !== $method) {
                continue;
            }
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
            $regex = '#^' . rtrim($regex, '/') . '$#';
<<<<<<< HEAD

            if (preg_match($regex, $path, $matches)) {
=======
            if (preg_match($regex, rtrim($path, '/'), $matches)) {
>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4
                array_shift($matches);
                $this->invoke($action, $matches);
                return;
            }
        }
<<<<<<< HEAD

=======
>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4
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
