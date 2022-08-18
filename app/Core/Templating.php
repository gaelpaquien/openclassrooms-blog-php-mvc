<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Templating extends Router
{

    private FilesystemLoader $loader;

    protected Environment $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache',
        ]);
    }

    public function view(string $path, $datas = [])
    {
        echo $this->twig->render($path, $datas);
    }
}
