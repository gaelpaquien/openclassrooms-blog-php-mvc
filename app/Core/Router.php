<?php
namespace App\Core;

use AltoRouter;

class Router
{

    private AltoRouter $router;

    public function __construct()
    {
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $path, ?string $name = null): self
    {
        $this->router->map('GET', $url, $path, $name);
        return $this;
    }

    public function post(string $url, string $path, ?string $name = null): self
    {
        $this->router->map('POST', $url, $path, $name);
        return $this;
    }

    public function url(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    public function start(): self
    {
        $match = $this->router->match();
        // Checks if route match
        if (isset($match['target'])) {
            // Explore array path and get controller->method
            $path = $match['target'];
            $pathExplode = explode('@', $path);
            $controller = 'App\Controllers\\' . $pathExplode[0];
            $method = $pathExplode[1];
        } else {
            $controller = 'App\Controllers\MainController';
            $method = 'error';
        }
        
        // Calling the class->method with the parameters of the URL
        $class = new $controller;
        $class->setParams($match['params']);
        $class->$method();

        $router = $this;
        return $this;
    }
    
}
