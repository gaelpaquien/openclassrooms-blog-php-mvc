<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Templating extends Router {

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
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache',
        ]);
    }

    public function view(string $path, $datas = []) 
    {
        echo $this->twig->render($path, $datas);
    }

}