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

    public function get(string $url, string $controller, ?string $name = null): self
    {
        $this->router->map('GET', $url, $controller, $name);
        return $this;
    }

    public function post(string $url, string $controller, ?string $name = null): self
    {
        $this->router->map('POST', $url, $controller, $name);
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
            $controller = $match['target'];

            $params = $match['params'];
        } else {
            $controller = 'old/Errors' . DIRECTORY_SEPARATOR . '404';
        }
        $router = $this;
        require ROOT . '/app/Controllers/' . $controller . '.php';
        return $this;
    }
    
}
