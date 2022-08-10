<?php
namespace App\Core;

class Router {
    
    /**
     * @var string
     */
    private $controllerPath;
    
    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct(string $controllerPath)
    {
        $this->controllerPath = $controllerPath;
        $this->router = new \AltoRouter();
    }

    public function get (string $url, string $controller, ?string $name = null): self
    {
        $this->router->map('GET', $url, $controller, $name);
        return $this;
    }

    public function post (string $url, string $controller, ?string $name = null): self
    {
        $this->router->map('POST', $url, $controller, $name);
        return $this;
    }

    public function url(string $name, array $params = []) 
    {
        return $this->router->generate($name, $params);
    }

    public function run ()
    {
        $match = $this->router->match();
        if(isset($match['target'])) {
            $controller = $match['target'];
            $params = $match['params'];
        } else {
            $controller = 'error404';
        }
        $router = $this;
        require $this->controllerPath . DIRECTORY_SEPARATOR .  $controller . '.php';
           
        return $this;
    }

}
