<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Router {
    
    /**
     * @var string
     */
    private $controllerPath;
    
    /**
     * @var AltoRouter
     */
    private $router;

    /**
    * @var Twig
    */
    private $loader;

    /**
    * @var Twig
    */
    protected $twig;

    public function __construct(string $controllerPath)
    {
        $this->controllerPath = $controllerPath;
        $this->router = new \AltoRouter();
        $this->loader = new FilesystemLoader(ROOT . '/templates');
        $this->twig = new Environment($this->loader);
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
            $controller = 'Errors' . DIRECTORY_SEPARATOR . '404';
        }
        $router = $this;
        //$this->twig->display($controller . '.html.twig');
        require $this->controllerPath . DIRECTORY_SEPARATOR .  $controller . '.php';
           
        return $this;
    }

}
