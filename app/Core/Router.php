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
        // GET route
        $this->router->map('GET', $url, $path, $name);
        return $this;
    }

    public function post(string $url, string $path, ?string $name = null): self
    {
        // POST route
        $this->router->map('POST', $url, $path, $name);
        return $this;
    }

    public function url(string $name, array $params = []): string
    {
        // Generate URL
        return $this->router->generate($name, $params);
    }

    public function start(): self
    {
        $match = $this->router->match();

        // Check if route match
        if (isset($match['target'])) {
            // Explore array path and get controller->method
            $path = $match['target'];
            $pathExplode = explode('@', $path);
            $controller = 'App\Controllers\\' . $pathExplode[0];
            $method = $pathExplode[1];
        } else {
            // Return controller->method for Error 404
            $controller = 'App\Controllers\MainController';
            $method = 'errorNotFound';
        }
        
        // Calling class->method with parameters of route
        $class = new $controller;
        // Set params for controller if route match
        if ($match !== false) {
            $class->setParams($match['params']);
        }
        
        $class->$method();

        return $this;
    }
    
}
