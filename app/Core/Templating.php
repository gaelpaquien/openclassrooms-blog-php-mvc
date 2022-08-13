<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Templating {

    /**
    * @var Twig
    */
    private $loader;

    /**
    * @var Twig
    */
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/templates');
        $this->twig = new Environment($this->loader);
    }

    public function template(string $name) 
    {
        return $this->twig->display($name);
    }

}