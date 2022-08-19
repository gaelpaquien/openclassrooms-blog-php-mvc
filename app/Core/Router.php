<?php
namespace App\Core;

use AltoRouter;

class Router
{

    private AltoRouter $router;

    public string $method;

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

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run()
    {
        $match = $this->router->match();
        if (isset($match['target'])) {
            $path = $match['target'];

        // Explore the array and get the controller and the method
        $pathExplode = explode('@', $path);
        $controller = 'App\Controllers\\' . $pathExplode[0];
        $method = $pathExplode[1];

            $params = $match['params'];
            define('PARAMS', $params);
        } else {
            $controller = 'App\Controllers\MainController';
            $method = 'error';
        }
        $router = $this;

        $class = new $controller;
        $class->$method();

        return $this;
    }
    
}
